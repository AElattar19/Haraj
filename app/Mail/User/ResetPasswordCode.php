<?php

namespace App\Mail\User;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class ResetPasswordCode extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public $code;

        public function __construct($code)
        {
            $this->code = $code;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this->view('emails.reset_password_code', [
                'code' => $this->code,
            ])->subject(t_('Reset Password Code'))->from(env('MAIL_FROM_ADDRESS',
                'no-replay@on-wingez.com'), 'No Replay');
        }
    }
