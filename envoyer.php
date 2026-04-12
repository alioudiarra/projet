<?php

 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$gmail_email    = "alioudiarrapro@gmail.com";
$gmail_password = "vqrx qsqn vosa bpxf"; 

$destinataires = [
    "Ibrahimdjidji250@gmail.com",
    "Fommarc5@gmail.com",
];
// ── 3. NETTOYAGE DES DONNÉES ─────────────────────────────────
function nettoyer($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
 
$nom            = isset($_POST['nom'])            ? nettoyer($_POST['nom'])            : '';
$email          = isset($_POST['email'])          ? nettoyer($_POST['email'])          : '';
$numero_annonce = isset($_POST['numero_annonce']) ? nettoyer($_POST['numero_annonce']) : '';
$sujet          = isset($_POST['sujet'])          ? nettoyer($_POST['sujet'])          : '';
$message        = isset($_POST['message'])        ? nettoyer($_POST['message'])        : '';
 
// ── 4. VALIDATION ─────────────────────────────────────────────
$erreurs = [];
 
if (empty($nom))                                $erreurs[] = "Le nom est requis.";
if (empty($email))                              $erreurs[] = "L'email est requis.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "L'email n'est pas valide.";
if (empty($numero_annonce))                     $erreurs[] = "Le numéro d'annonce est requis.";
if (empty($sujet))                              $erreurs[] = "Le sujet est requis.";
if (empty($message))                            $erreurs[] = "Le message est requis.";
 
// ── 5. ENVOI AVEC PHPMAILER ───────────────────────────────────
if (empty($erreurs)) {
 
    $mail = new PHPMailer(true);
 
    try {
        // ── Configuration SMTP Gmail ──
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $gmail_email;
        $mail->Password   = $gmail_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
 
        // ── Expéditeur ──
        $mail->setFrom($gmail_email, 'Site de Réclamation');
 
        // ── Répondre directement au client ──
        $mail->addReplyTo($email, $nom);
 
        // ── Ajouter tous les membres du groupe ──
        foreach ($destinataires as $dest) {
            $mail->addAddress($dest);
        }
 
        // ── Sujet ──
        $mail->Subject = "Nouvelle réclamation – $sujet (Annonce : $numero_annonce)";
 
        // ── Corps HTML ──
        $mail->isHTML(true);
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto;'>
 
            <div style='background: #f56a00; padding: 24px; border-radius: 10px 10px 0 0;'>
                <h2 style='color: white; margin: 0;'>🔔 Nouvelle Réclamation</h2>
            </div>
 
            <div style='background: #f9f9f9; padding: 24px; border: 1px solid #eee;'>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 10px; font-weight: bold; color: #555; width: 40%;'>👤 Nom / Prénom</td>
                        <td style='padding: 10px;'>$nom</td>
                    </tr>
                    <tr style='background: #fff;'>
                        <td style='padding: 10px; font-weight: bold; color: #555;'>📧 Email client</td>
                        <td style='padding: 10px;'><a href='mailto:$email'>$email</a></td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; font-weight: bold; color: #555;'>🔢 N° Annonce</td>
                        <td style='padding: 10px;'>$numero_annonce</td>
                    </tr>
                    <tr style='background: #fff;'>
                        <td style='padding: 10px; font-weight: bold; color: #555;'>📋 Sujet</td>
                        <td style='padding: 10px;'>$sujet</td>
                    </tr>
                </table>
 
                <div style='margin-top: 20px; background: white; border-left: 4px solid #f56a00; padding: 16px; border-radius: 4px;'>
                    <p style='font-weight: bold; color: #555; margin: 0 0 10px;'>💬 Message :</p>
                    <p style='margin: 0; line-height: 1.6;'>$message</p>
                </div>
            </div>
 
            <div style='background: #eee; padding: 14px; border-radius: 0 0 10px 10px; text-align: center;'>
                <p style='font-size: 12px; color: #999; margin: 0;'>
                    Message envoyé depuis le formulaire de réclamation du site.
                </p>
            </div>
 
        </div>
        ";
 
        // Version texte si HTML ne s'affiche pas
        $mail->AltBody = "Nouvelle réclamation\nNom: $nom\nEmail: $email\nAnnonce: $numero_annonce\nSujet: $sujet\nMessage: $message";
 
        $mail->send();
 
        header("Location: formulaire_reclamation.html?statut=succes");
        exit;
 
    } catch (Exception $e) {
        header("Location: contact.php?statut=erreur");
        exit;
    }
 
} else {
    header("Location: contact.php?statut=erreur");
    exit;
}
?>