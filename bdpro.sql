-- 1. Table Utilisateurs (Indépendante)
CREATE TABLE users (
    id_u INT AUTO_INCREMENT,
    pseudo VARCHAR(50),
    nom VARCHAR(50),
    email VARCHAR(100),
    mpd VARCHAR(255),
    phone VARCHAR(10),
    perm INT,
    PRIMARY KEY (id_u)
);

-- 2. Table Annonces (Dépend de users)
CREATE TABLE annnonce (
    id_a INT AUTO_INCREMENT,
    title VARCHAR(100),
    `desc` VARCHAR(255), -- 'desc' est un mot réservé en SQL, on utilise des backticks
    price INT,
    status INT,
    type VARCHAR(100),
    img VARCHAR(100),
    date_cr VARCHAR(50),
    id_u INT,
    PRIMARY KEY (id_a),
    FOREIGN KEY (id_u) REFERENCES users(id_u)
);

-- 3. Table Conversations (Dépend de l'annonce et des deux utilisateurs)
CREATE TABLE convers (
    id_c INT AUTO_INCREMENT,
    id_a INT,
    id_u1 INT,
    id_u2 INT,
    PRIMARY KEY (id_c),
    FOREIGN KEY (id_a) REFERENCES annnonce(id_a),
    FOREIGN KEY (id_u1) REFERENCES users(id_u),
    FOREIGN KEY (id_u2) REFERENCES users(id_u)
);

-- 4. Table SMS / Messages (Dépend de l'utilisateur et de la conversation)
CREATE TABLE sms (
    id_s INT AUTO_INCREMENT,
    id_u INT,
    date_send INT, -- Note: Généralement on utilise DATETIME, mais j'ai gardé ton type INTEGER
    sms VARCHAR(255),
    id_c INT,
    PRIMARY KEY (id_s),
    FOREIGN KEY (id_u) REFERENCES users(id_u),
    FOREIGN KEY (id_c) REFERENCES convers(id_c)
);

-- 5. Table Like (Table de liaison entre users et annnonce)
CREATE TABLE `like` (
    id_l INT AUTO_INCREMENT,
    id_u INT,
    id_a INT,
    PRIMARY KEY (id_l),
    FOREIGN KEY (id_u) REFERENCES users(id_u),
    FOREIGN KEY (id_a) REFERENCES annnonce(id_a)
);