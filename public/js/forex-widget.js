init: function () {
    var widget = this;

    widgets.webId = "b9238183-eaff-447f-ba0d-3bedfb01bdff";
    widgets.baseUrl = "widgets.tradologic.net/Widgets//v6";
    widgets.apiUrl = "https://api2.tradologic.net";
    widgets.advFeedUrl = 'https://advfeed.tradologic.net';
    widget.getEasyForexOptions();
    widget.getEasyForexDailyChange();
    widget.getEasyForexPrices();
}

getEasyForexOptions: function () {
    var widget = this;
    var resources = {
            options: {
                game:"Forex",
                hash:""
            }
        };
    getAnonymousResources(resources, widget.processResources);

    widgets.timers.updateEasyForexOptions = setInterval(function () {
            widget.updateEasyForexOptionsCount++;
            widget.getEasyForexOptions();
        }, 1000);

    }

    getAnonymousResources: function (resources, callback) {
        var options = {
            token: widgets.token.accessToken,
            resources: JSON.stringify(resources)
        };
        return this.callWeb('v1/merge', options, callback);
    }

    callWeb: function (service, data, callback, args) {
        data.isAnonymous = true;
        widgets.api.call(widgets.apiUrl + '/' + service, data, callback, args);
    }

//direct API calls
    call: function (url, data, callback, args) {
        var method = 'get';
        var isAnonymous = false;

        if (data.method) {
            method = data['method'];
            delete data['method'];
        }
        if (data.isAnonymous) {
            isAnonymous = data['isAnonymous'];
            delete data['isAnonymous'];
        }
        widgets.requestsInProgress++;

        // add debug param
        if (widgets.debugKey != '') {
            url = helper.addQueryParameter(url, 'wdebug', widgets.debugKey);
        }

    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: 'json',
        cache: false,
        crossDomain: true,
        beforeSend: function (xhr) {
            if (!isAnonymous && widgets.token && widgets.token.accessToken) {
                xhr.setRequestHeader('Authorization', "oauth oauth_token=" + widgets.token.accessToken);
            }
        },
        complete: function (response, status, fullResponse) {
            widgets.requestsInProgress--;
            //Checks if you have valid response
            if (response.responseText && response.responseText.length == 0 && status.toLowerCase() == "error") {
                return;
            }

            if (response.status == 403 & widgets.isFirstStart) {
                //if the token is broken and it's the initial loading of the widgets - refresh the token
                widgets.getTokenWithRefresh(true);
            }

            //attempt to convert to JSON
            try {
                var result = $.parseJSON(response.responseText);
                //if the token is broken for any reason - delete the cookie and refresh the page
                if (result.code == 400 && result.data.type == "Refresh_Unsuccessfull") {
                    $.removeCookie(widgets.tokenCookie);
                    window.location = window.location;
                }
            } catch (e) {
                //if this is invalid JSON - do not proceed
                return;
            }

            //process callbacks
            if (callback) {
                if (typeof callback == 'object') {
                    //process multiple callbacks
                    $.each(callback, function (i, call) {
                        if (typeof call == 'function') {
                            return call(result, args);
                        }
                    });
                } else {
                    //process single callback
                    return callback(result, args);
                }

            }
            return result;
        }
    });
}

processResources: function (response) {
    if (!response || !response.data) {
        return false;
    }
    if (response.serverTime) {
        widgets.serverDateTime = response.serverTime; //update server time variable on every resource call
        if (isNaN(new Date(widgets.serverDateTime.dateTime))) {// IE8/9 will return NaN for ISO formatted dates
            widgets.serverDateTime.dateTime = new Date(response.serverTime.timestamp);
            widgets.serverDateTime.timestamp = response.serverTime.timestamp;
        }
        widgets.setServerDateTimeTimer();
    }

    $.each(response.data, function (resourceName, resource) {
        var processor = 'process' + helper.ucfirst(resourceName);

        if (easyForexHelper[processor]) {
            easyForexHelper[processor](resource);
        }
    });
}

processOptions: function (response) {
    var widget = this;
    if (!response || response.code != 200) {
        return false;
    };

    if (response.data && response.data.type == 'NoOptions') {
        $(window).trigger(widgets.events.noEasyForexOptions);
        return;
    };

    if (easyForexHelper.optionsHash === response.hash) {
        return false;
    };

    easyForexHelper.optionsHash = response.hash;
    easyForexHelper.options = response.data;
    easyForexHelper.sortOptinsByType(easyForexHelper.options);
    $(window).trigger(widgets.events.easyForexOptionsUpdated);
}

getEasyForexDailyChangeValues: function (forexIDs, callback) {
    $.ajax({
        url: 'https://advfeed.tradologic.net/Services.ashx/GetDailyChanges?filterbyid=' + forexIDs,
        dataType: 'jsonp',
        success: function (result) {
            if (!result || result == null || Object.keys(result).length == 0) {
                var errorObj = new Object();
                errorObj.code = 503;
                errorObj.message = "Failed";
                errorObj.data = result;
                callback(errorObj);
                return;
            };

            var resultObj = new Object();

            resultObj.code = 200;
            resultObj.message = "OK";
            resultObj.data = result;

            callback(resultObj);
        }
    });
}

    getEasyForexDailyChange: function() {
        var widget = this,
            ids = '',
            length = widget.options.length;

        $.each(widget.options, function (i, item) {
            ids += item.id.toString() + (i < length-1 ? ',' : '');
        });

        getEasyForexDailyChangeValues(ids, function(response) {
            if (!response || response.code != 200) {
                return false;
            };

            var allDailyData = response.data;

            $.each(easyForexHelper.options, function (i, option) {
                if (typeof allDailyData[option.id] != 'undefined') {
                    option.dailyChange = allDailyData[option.id].Change;
                    option.openPrice = allDailyData[option.id].OpenPrice;
                };
            });
        });
    }

    getEasyForexPrices: function () {
        var widget = this,
            resources = {
                forexPrices: {}
            };

        resources.forexOpenTrades = {};
        resources.forexOpenTrades = {
            includeOffers: true,
            filterByOptionType: 'forex'
        };

        widgets.api.getAnonymousResources(resources, widget.processResources);

        clearInterval(widgets.timers.updateEasyForexPriceInterval);

        widgets.timers.updateEasyForexPriceInterval = setInterval(function () {
            widget.updateEasyForexPricesCount++;
            widget.getEasyForexPrices();
        }, widget.updateEasyForexPriceIntervalInMs);

        if (widget.updateEasyForexPricesCount >= 4) {
            widget.updateEasyForexPricesCount = 0;
        }
    }

processForexPrices: function (response) {
    var widget = this;

    if (!response || !response.data) {
        return;
    };

    if (widget.updatePriceRequestCount == 1) {
        widget.assetsPrices = response.data;
    } else {
        $.each(response.data, function (i, price) {
            widget.assetsPrices[i] = price;
        });
    };

    if (response.data && Object.keys(response.data).length > 0) {
        $(window).trigger(widgets.events.easyForexAssetPricesUpdated);
    };
}

updateEasyForexPrices: function () {
    var widget = this,
        rows = widget.elementsCache.assetsList.find('[data-taid]');

    if (rows.length < 1) {
        return;
    };

    $.each(easyForexHelper.assetsPrices, function (i, asset) {
        var row = rows.filter('[data-taid="' + i + '"]');
        if (row.length > 0) {

            var averagePrice = ((parseFloat(asset.bid) + parseFloat(asset.ask)) / 2).toFixed(asset.accuracy),
                priceElement = row.find('[data-type="averageprice"]'),
                className = priceElement.attr('data-direction'),
                dailyChangeElement = row.find('[data-type="dailychange"]'),
                currentPrice = parseFloat(priceElement.text()).toFixed(asset.accuracy),
                currentTAID = i;

            if (widget.popupShown) {
                var popuDailyChangeElement = widget.elementsCache.popupContainer.find('[data-type="dailychange"]'),
                    popuPriceElement = widget.elementsCache.popupContainer.find('[data-type="averageprice"]'),
                    popupTAID = widget.elementsCache.popupContainer.data('taid');
            };

            widget.eachCurrentPrice = currentPrice;

            $.each(easyForexHelper.options, function (i, asset) {
                if (typeof asset != 'undefined') {
                    if (typeof asset.dailyChange != 'undefined' && asset.id == currentTAID && currentPrice != "NaN") {
                        asset.dailyChange = ((widget.eachCurrentPrice - asset.openPrice) / asset.openPrice) * 100;
                        $(dailyChangeElement).removeClass('up down').addClass(asset.dailyChange < 0 ? 'down' : 'up').html(Math.abs(asset.dailyChange).toFixed(2) + '%');

                        if (widget.popupShown && popupTAID == currentTAID) {
                            $(popuDailyChangeElement).removeClass('up down').addClass(asset.dailyChange < 0 ? 'down' : 'up').html(Math.abs(asset.dailyChange).toFixed(2) + '%');
                        };
                    };
                };
            });

            if (className && currentPrice != averagePrice) {
                priceElement.removeClass(className);

                if (widget.popupShown && popupTAID == currentTAID) {
                    popuPriceElement.removeClass(className);
                };
            };

            if (currentPrice == averagePrice) {
                return;
            } else if (currentPrice < averagePrice) {
                className = 'up';
                priceElement.attr('data-direction', className);
            } else {
                className = 'down';
                priceElement.attr('data-direction', className);
            };

            row.find('[data-type="averageprice" ]').addClass(className).html(averagePrice);

            if (widget.popupShown && popupTAID == currentTAID) {
                popuPriceElement.addClass(className).html(averagePrice);
            };
        };
    });
}

