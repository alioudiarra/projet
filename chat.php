<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['id_u'])) { header("Location: connexion.php"); exit(); }

$my_id = (int)$_SESSION['id_u'];
$id_c = (int)($_GET['id_c'] ?? 0);

if ($id_c === 0) { header("Location: messagerie.php"); exit(); }

// 1. Action : Envoyer un message
if (isset($_POST['send']) && !empty(trim($_POST['message']))) {
    $sms = mysqli_real_escape_string($conn, $_POST['message']);
    $insert = "INSERT INTO sms (id_u, sms, id_c, date_send) VALUES ($my_id, '$sms', $id_c, NOW())";
    mysqli_query($conn, $insert);
    header("Location: chat.php?id_c=$id_c");
    exit();
}

// 2. Récupérer les infos de l'annonce
$infoQuery = mysqli_query($conn, "SELECT a.title, a.img FROM convers c JOIN annnonce a ON c.id_a = a.id_a WHERE c.id_c = $id_c");
$info = mysqli_fetch_assoc($infoQuery);

// 3. Récupérer TOUS les messages
$query = "SELECT * FROM sms WHERE id_c = $id_c ORDER BY date_send ASC";
$messages = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chat - <?= htmlspecialchars($info['title'] ?? 'Discussion') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .chat-container { max-width: 600px; margin: 20px auto; }
        .chat-box { 
            height: 500px; 
            overflow-y: auto; 
            display: flex; 
            flex-direction: column; 
            padding: 20px; 
            background: white;
        }
        .msg { max-width: 75%; margin-bottom: 15px; padding: 12px; border-radius: 15px; position: relative; }
        
        /* TES MESSAGES EN ROUGE */
        .msg-me { 
            align-self: flex-end; 
            background-color: #dc3545; /* ROUGE */
            color: white; 
            border-bottom-right-radius: 2px;
        }
        
        /* MESSAGES DE L'AUTRE EN GRIS */
        .msg-other { 
            align-self: flex-start; 
            background-color: #e9ecef; 
            color: #333; 
            border-bottom-left-radius: 2px;
        }
        
        .time { font-size: 0.75em; display: block; margin-top: 5px; opacity: 0.8; }
        .msg-me .time { text-align: right; color: #ffc2c2; }
    </style>
</head>
<body>

<div class="container chat-container shadow">
    <div class="card border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center">
            <a href="messagerie.php" class="btn btn-outline-danger btn-sm me-3 border-0">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <img src="<?= $info['img'] ?>" width="45" height="45" class="rounded me-2" style="object-fit: cover;">
            <strong class="text-dark"><?= htmlspecialchars($info['title']) ?></strong>
        </div>
        
        <div class="chat-box" id="chatBox">
            <?php while($s = mysqli_fetch_assoc($messages)): ?>
                <?php $isMe = ((int)$s['id_u'] === $my_id); ?>
                <div class="msg <?= $isMe ? 'msg-me' : 'msg-other' ?>">
                    <?= htmlspecialchars($s['sms']) ?>
                    <span class="time"><?= date('H:i', strtotime($s['date_send'])) ?></span>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="card-footer bg-white p-3">
            <form method="POST" class="d-flex">
                <input type="text" name="message" class="form-control me-2 border-danger-subtle" placeholder="Votre message..." required autocomplete="off">
                <button name="send" class="btn btn-danger px-4">
                    <i class="bi bi-send"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const box = document.getElementById('chatBox');
    box.scrollTop = box.scrollHeight;
</script>

</body>
</html>