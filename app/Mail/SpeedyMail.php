<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpeedyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $destino;
    private $adjunto;
    private $ticket;
    private $consultor;
    private $solicitante;
    private $severidad;
    private $tecnologia;
    private $descripcion;
    private $creacion;
    private $titulo;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($destino,$adjunto,$ticket,$consultor,$solicitante,$severidad,$tecnologia,$descripcion,$creacion)
    {
        $this->destino=$destino;
        $this->adjunto=$adjunto;
        $this->ticket=$ticket;
        $this->consultor=$consultor;
        $this->solicitante=$solicitante;
        $this->severidad=$severidad;
        $this->tecnologia=$tecnologia;
        $this->descripcion=$descripcion;
        $this->creacion=$creacion;
        $this->titulo="Asignación Ticket ".$this->ticket." del cliente Speedy Movil en relación a la Tecnología ".$this->tecnologia." con ".$this->severidad;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: $this->destino,
            cc: [$this->adjunto,'karmina@tecnomedia.com.mx'],
            subject: $this->titulo,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.speedy',
            with: [
                'ticket' => $this->ticket,
                'solicitante' => $this->solicitante,
                'creacion' => $this->creacion,
                'severidad' => $this->severidad,
                'descripcion' => $this->descripcion,
                'tecnologia' => $this->tecnologia,
                'consultor' => $this->consultor,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
