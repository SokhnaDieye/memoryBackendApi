<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FactureMail extends Mailable
{
    use Queueable, SerializesModels;
    public $payment;
    public $pdf;

    public function __construct($pdf, $payment)
    {
        $this->payment = $payment;
        $this->pdf = $pdf;
    }
    public function build()
    {
        $pdf = PDF::loadView('invoice', [
            'payment' => $this->payment,
            'client' => $this->payment->client,
            'project' => $this->payment->project
        ]);

        return $this->from('dieyesokhna2021@gmail.com', 'Sokhna')
            ->to($this->payment->client->contact_email)
            ->view('order_completed')
            ->with([
                'order' => $this->payment,
            ])
            ->attachData($this->pdf->output(), 'facture.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

   /* public function build()
    {
        $pdf = PDF::loadView('invoice', [
            'payment' => $this->payment,
            'client' => $this->payment->client,
            'project' => $this->payment->project
        ]);

        return $this->from( address: 'dieyesokhna2021@gmail.com', name: 'sokhna')
            ->to($this->payment->client->email)
            ->view( view: 'order_completed')
            ->with([
                'order' => $this->payment,
        ])
        ->attachData($this->pdf->output(), 'facture.pdf', [
                'mime' => 'application/pdf',
        ]);
    }*/
}
