<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class ContactController extends Controller
{
    public function contactAction() {

        return view('contact/contact');
    }

    public function contactPostAction(Request $request) {

        $validated = Validator::make(
            [
                'inputName' => $request->input('inputName'),
                'inputEmail' => $request->input('inputEmail'),
                'textareaContact' => $request->input('textareaContact')
            ],
            [
                'inputName' => 'required',
                'inputEmail' => 'required|email',
                'textareaContact' => 'required'
            ]
        );

        if ($validated->fails()) {

            return redirect()->route('contact')->with(['error' => 'Erreur lors de l\'envoi du message']);
        }

        require '../config.php';

        $mail = new PHPMailer(true);

        try {
            
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $data['usermail'];
            $mail->Password   = $data['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($data['usermail'], 'contact tapizza');
            $mail->addAddress($data['mailreceive']);
            $mail->addReplyTo(htmlspecialchars($request->input('inputEmail')), htmlspecialchars($request->input('inputName')));

            $mail->isHTML(true);
            $mail->Subject = 'New contact message Tapizza';
            $mail->Body    = 'Mail contact: ' . htmlspecialchars($request->input('inputEmail')) . '<br>' . htmlspecialchars($request->input('textareaContact'));

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();

            $message = ['success' => 'Message envoyé'];

        } 
        
        catch (Exception $e) {

            $message = ['error' => 'Erreur lors de l\'envoi du message'];
        }

        return redirect()->route('contact')->with($message);

    }
}
