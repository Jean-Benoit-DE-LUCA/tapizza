<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class ResetPasswordController extends Controller
{
    //

    public function mailAction() {

        return view('reset-password/mail');
    }

    public function mailPostAction(Request $request) {

        $userObj = new User();
        $checkUser = $userObj->getUser(htmlspecialchars($request->input('inputEmail')));

        if (count($checkUser) !== 0) {

            $token = md5(bin2hex(random_bytes(64)));

            $date = getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . ' ' . getdate()['hours'] + 2 . ':' . getdate()['minutes'] . ':' . getdate()['seconds'];
            
            $passwordResetObj = new PasswordReset();
            $insertResetToken = $passwordResetObj->insertResetToken(htmlspecialchars($request->input('inputEmail')), $token, $date);

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
    
                $mail->setFrom($data['usermail'], 'Contact Tapizza');
                $mail->addAddress(htmlspecialchars($request->input('inputEmail')));
                $mail->addReplyTo(htmlspecialchars($request->input('inputEmail')));
    
                $mail->isHTML(true);
                $mail->Subject = 'Email de recuperation de mot de passe "tapizza"';

                $mail->Body    = 'Cher utilisateur,' . '<br>' . 'Veuillez cliquer sur le lien ci-dessous afin de reinitialiser votre mot de passe.' . '<br>' . 'http://localhost:8000/motdepasse?key=' . $token . '&mail=' . htmlspecialchars($request->input('inputEmail')) . '<br>' . '<br>' . '"TAPIZZA" Website';
    
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
    
                $mail->send();
    
                $message = ['success' => 'Email envoyé'];
    
            } 
            
            catch (Exception $e) {
    
                $message = ['error' => 'Erreur lors de l\'envoi de l\'email'];
            }

            return redirect()->route('mail')->with($message);
        }

        else if (count($checkUser) == 0) {

            return redirect()->route('mail')->with(['error' => 'Utilisateur non enregistré']);
        }
    }

    public function resetPasswordAction(Request $request) {

        if ($request->has('key') && $request->has('mail')) {

            $passwordResetObj = new PasswordReset();
            $checkData= $passwordResetObj->selectResetToken($request->input('mail'), $request->input('key'));

            if (!empty($checkData)) {

                $date = getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'] . ' ' . getdate()['hours'] + 2 . ':' . getdate()['minutes'] . ':' . getdate()['seconds'];
                $date = date_create($date);
        
                $dateToken = date_create($checkData[0]->created_at);
                $dateTokenPlusOneDay = date_add($dateToken, date_interval_create_from_date_string('1 days'));
        
                if ($date > $dateTokenPlusOneDay) {
                    
                    $deleteToken = $passwordResetObj->deleteResetToken($request->input('mail'));
        
                    return redirect()->route('mail')->with(['error' => 'Délai de 24H dépassé, veuillez générer un autre email de réinitialisation']);
                }
        
                else {

                    return view('reset-password/reset', [
                        'email' => $request->input('mail'),
                        'tokenReset' => $request->input('key')
                    ]);
                }
            }

            else {

                return redirect()->route('mail')->with(['error' => 'Veuillez régénérer un email de réinitialisation']);
            }

        }

        else {

            return redirect()->route('home');
        }
        
    }

    public function resetPasswordPostAction(Request $request) {

        $validated = Validator::make(
            [
                'inputPassword' => $request->input('inputPassword'),
                'inputPassword_confirmation' => $request->input('inputPassword_confirmation'),
                'input-mail-hidden' => $request->input('input-mail-hidden'),
                'input-token-hidden' => $request->input('input-token-hidden')
            ],
            [
                'inputPassword' => 'required',
                'inputPassword_confirmation' => 'required|same:inputPassword',
                'input-mail-hidden' => 'required',
                'input-token-hidden' => 'required'
            ]
        );

        if ($validated->fails()) {

            return redirect()->route('resetPassword', 
                [
                    'key' => $request->input('input-token-hidden'),
                    'mail' => $request->input('input-mail-hidden')
                ])
                ->with(['error' => 'Erreur lors de la modification, veuillez réessayer']);
        }

        $passwordResetObj = new PasswordReset();
        $deleteToken = $passwordResetObj->deleteResetToken($request->input('input-mail-hidden'));

        $userObj = new User();
        $updatePassword = $userObj->updatePassword(Hash::make($request->input('inputPassword')), $request->input('input-mail-hidden'));

        return redirect()->route('home')->with(['success' => 'Mot de passe modifié avec succès']);

    }
}
