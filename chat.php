<?php
// 1. DEBUGGAGE (Indispensable pour ton camarade sur Windows)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'database.php';

// Vérification de la session
if (!isset($_SESSION['id_u'])) { 
    header("Location: connexion.php"); 
    exit(); 
}

$my_id = (int)$_SESSION['id_u'];
$id_c = (int)($_GET['id_c'] ?? 0);

if ($id_c === 0) { 
    header("Location: messagerie.php"); 
    exit(); 
}

// 2. ACTION : ENVOYER UN MESSAGE (Version corrigée)
if (isset($_POST['send']) && !empty(trim($_POST['message']))) {
    $sms = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Date au format PHP pour éviter les bugs "Out of range" sur Windows
    $date = date('Y-m-d H:i:s');
    
    $insert = "INSERT INTO sms (id_u, sms, id_c, date_send) VALUES ($my_id, '$sms', $id_c, '$date')";
    
    // EXECUTION DE LA REQUETE (C'est cette ligne qui manquait !)
    if (mysqli_query($conn, $insert)) {
        header("Location: chat.php?id_c=$id_c");
        exit();
    } else {
        // En cas d'erreur SQL, on l'affiche pour debugger
        die("Erreur lors de l'envoi : " . mysqli_error($conn));
    }
}

// 3. RECUPERER LES INFOS DE L'ANNONCE (Vérifie bien s'il y a 2 ou 3 'n' à annnonce)
$infoQuery = mysqli_query($conn, "SELECT a.title, a.img FROM convers c JOIN annnonce a ON c.id_a = a.id_a WHERE c.id_c = $id_c");
$info = mysqli_fetch_assoc($infoQuery);

// 4. RECUPERER TOUS LES MESSAGES
$query = "SELECT * FROM sms WHERE id_c = $id_c ORDER BY date_send ASC";
$messages = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion - <?= htmlspecialchars($info['title'] ?? 'Chat') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .chat-container { max-width: 600px; margin: 20px auto; }
        .chat-box { 
            height: 500px; 
            overflow-y: auto; 
            display: flex; 
            flex-direction: column; 
            padding: 20px; 
            background: #ffffff;
            border-radius: 0;
        }
        .msg { max-width: 75%; margin-bottom: 15px; padding: 12px 16px; border-radius: 18px; position: relative; font-size: 15px; line-height: 1.4; }
        
        /* TES MESSAGES (ROUGE) */
        .msg-me { 
            align-self: flex-end; 
            background-color: #dc3545; 
            color: white; 
            border-bottom-right-radius: 2px;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
        }
        
        /* MESSAGES DE L'AUTRE (GRIS) */
        .msg-other { 
            align-self: flex-start; 
            background-color: #f1f0f0; 
            color: #333; 
            border-bottom-left-radius: 2px;
        }
        
        .time { font-size: 10px; display: block; margin-top: 5px; opacity: 0.7; }
        .msg-me .time { text-align: right; color: #ffcccc; }
        .msg-other .time { color: #888; }

        .card-header { border-bottom: 1px solid #eee; }
        .card-footer { border-top: 1px solid #eee; }
    </style>
</head>
<body>

<div class="container chat-container shadow-lg p-0">
    <div class="card border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex align-items-center">
            <a href="messagerie.php" class="btn btn-outline-danger btn-sm me-3 border-0 rounded-circle">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <?php if(!empty($info['img'])): ?>
                <img src="<?= $info['img'] ?>" width="45" height="45" class="rounded-circle me-3" style="object-fit: cover; border: 1px solid #eee;">
            <?php endif; ?>
            <div>
                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($info['title'] ?? 'Discussion') ?></h6>
                <small class="text-success"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> En ligne</small>
            </div>
        </div>
        
        <div class="chat-box" id="chatBox">
            <?php if(mysqli_num_rows($messages) == 0): ?>
                <div class="text-center my-auto text-muted">
                    <i class="bi bi-chat-quote fs-1 opacity-25"></i>
                    <p>Aucun message. Commencez la discussion !</p>
                </div>
            <?php endif; ?>

            <?php while($s = mysqli_fetch_assoc($messages)): ?>
                <?php $isMe = ((int)$s['id_u'] === $my_id); ?>
                <div class="msg <?= $isMe ? 'msg-me' : 'msg-other' ?>">
                    <?= htmlspecialchars($s['sms']) ?>
                    <span class="time">
                        <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($s['date_send'])) ?>
                    </span>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="card-footer bg-white p-3">
            <form method="POST" class="d-flex align-items-center">
                <input type="text" name="message" class="form-control rounded-pill bg-light border-0 py-2 px-4 me-2" placeholder="Écrivez votre message..." required autocomplete="off">
                <button name="send" class="btn btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Scroll automatique vers le bas
    const box = document.getElementById('chatBox');
    box.scrollTop = box.scrollHeight;
</script>

</body>
</html>