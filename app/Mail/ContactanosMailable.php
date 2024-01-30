<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $nombre, public string $contenido, public string $email, public ?string $autenticado=null)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->email, $this->nombre),
            subject: 'Formulario Contacto Usuarios',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->autenticado=(auth()->user()!=null) ? "Usuario autenticado " : "Usuario Anonimo";
        return new Content(
            view: 'contactanos.formato',
            with: [
               'nombre'=>$this->nombre,
               'contenido'=>$this->contenido,
               'email'=>$this->email,
               'tipoUsuario'=>$this->autenticado, 
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
