<?php

namespace App\Mail;

use App\ICOBuyer;
use App\ICODeal;
use App\ICOProjects;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;
    public $project;
    public $deal;


    /**
     * Create a new message instance.
     *
     * @param ICOBuyer $buyer
     * @param ICOProjects $project
     * @param ICODeal $deal
     */
    public function __construct(ICOBuyer $buyer, ICOProjects $project, ICODeal $deal)
    {
        $this->buyer = $buyer;
        $this->project = $project;
        $this->deal = $deal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (file_exists(public_path() . "/" . $this->project->ico_screenshot)) :
            $attachFile = public_path() . "/" . $this->project->ico_screenshot;
        else :
            $attachFile = $this->project->ico_screenshot;
        endif;
        $ext = pathinfo($attachFile, PATHINFO_EXTENSION);
        return $this->view('email.order-summary')->attach($attachFile, ['as' => 'ICO_form_confirmation.' . $ext]);
    }
}
