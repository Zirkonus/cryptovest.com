<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
	protected $table = 'contact_form';

	protected $fillable = [
		'first_name',
		'last_name',
		'company',
		'email',
		'phone',
		'post_content',
        'ip',
        'department'
	];
}
