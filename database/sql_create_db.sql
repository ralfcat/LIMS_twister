CREATE TABLE Donor (
    donor_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    age INT,
    sex VARCHAR(10),
    address VARCHAR(255),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    blood_type VARCHAR(3),
    last_donation_date DATE,
    is_eligible BOOLEAN,
    account_activation_hash VARCHAR(64) UNIQUE
    unsubscribe_date DATE
);

CREATE TABLE Region (
    rid INT PRIMARY KEY AUTO_INCREMENT,
    region VARCHAR(100)
);

INSERT INTO Region (region) VALUES ('Blekinge');
INSERT INTO Region (region) VALUES ('Dalarna');
INSERT INTO Region (region) VALUES ('Gotland');
INSERT INTO Region (region) VALUES ('Gävleborg');
INSERT INTO Region (region) VALUES ('Halland');
INSERT INTO Region (region) VALUES ('Jämtland');
INSERT INTO Region (region) VALUES ('Jönköping');
INSERT INTO Region (region) VALUES ('Kalmar');
INSERT INTO Region (region) VALUES ('Kronoberg');
INSERT INTO Region (region) VALUES ('Norrbotten');
INSERT INTO Region (region) VALUES ('Skåne');
INSERT INTO Region (region) VALUES ('Stockholm');
INSERT INTO Region (region) VALUES ('Södermanland');
INSERT INTO Region (region) VALUES ('Uppsala');
INSERT INTO Region (region) VALUES ('Värmland');
INSERT INTO Region (region) VALUES ('Västerbotten');
INSERT INTO Region (region) VALUES ('Västernorrland');
INSERT INTO Region (region) VALUES ('Västmanland');
INSERT INTO Region (region) VALUES ('Västra Götaland');
INSERT INTO Region (region) VALUES ('Örebro');
INSERT INTO Region (region) VALUES ('Östergötland');

CREATE TABLE Blood_Bank (
    blood_bank_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    region_id INT,
    address VARCHAR(255),
    email VARCHAR(100),
    password VARCHAR(100),
    account_activation_hash VARCHAR(64) UNIQUE,
    FOREIGN KEY (region_id) REFERENCES Region(rid)
);
CREATE TABLE Donation (
    donation_id INT PRIMARY KEY AUTO_INCREMENT,
    donor_id INT,
    blood_bank_id INT,
    amount DECIMAL(5, 2),
    donation_date DATE,
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id),
    FOREIGN KEY (blood_bank_id) REFERENCES Blood_Bank(blood_bank_id)
);
CREATE TABLE Blood_Stock (
    blood_bank_id INT,
    blood_type VARCHAR(3),
    stock_level INT,
    threshold_level INT,
    PRIMARY KEY (blood_bank_id, blood_type),
    FOREIGN KEY (blood_bank_id) REFERENCES Blood_Bank(blood_bank_id)
);


-- This command will create blood stocks automatically upon registering 
DELIMITER $$

CREATE TRIGGER insert_blood_stock
AFTER INSERT ON Blood_Bank
FOR EACH ROW
BEGIN
    INSERT INTO Blood_Stock (blood_bank_id, blood_type, stock_level, threshold_level)
    VALUES (NEW.blood_bank_id, 'A+', 0, 10),
           (NEW.blood_bank_id, 'A-', 0, 10),
           (NEW.blood_bank_id, 'B+', 0, 10),
           (NEW.blood_bank_id, 'B-', 0, 10),
           (NEW.blood_bank_id, 'AB+', 0, 10),
           (NEW.blood_bank_id, 'AB-', 0, 10),
           (NEW.blood_bank_id, 'O+', 0, 10),
           (NEW.blood_bank_id, 'O-', 0, 10);
END$$

DELIMITER ;

CREATE TABLE Notification (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    notification_method VARCHAR(50),
    notification_date DATE,
    blood_bank_id INT,
    donor_id INT,
    rid INT,
    FOREIGN KEY (blood_bank_id) REFERENCES Blood_Bank(blood_bank_id),
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id),
    FOREIGN KEY (rid) REFERENCES Region(rid)
);
CREATE TABLE DonorNotification (
    donor_id INT,
    notification_id INT,
    PRIMARY KEY (donor_id, notification_id),
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id),
    FOREIGN KEY (notification_id) REFERENCES Notification(notification_id)
);



INSERT INTO notification (notification_id, notification_method, notification_date, blood_bank_id, donor_id)
VALUES 
(1, 'email', '2024-10-20', 1, 1),
(2, 'email', '2024-10-20', 1, 2),
(3, 'email', '2024-10-20', 1, 3),
(4, 'email', '2024-10-20', 1, 4),
(5, 'email', '2024-10-21', 1, 5),
(6, 'email', '2024-10-21', 1, 1),
(7, 'email', '2024-10-02', 1, 2),
(8, 'email', '2024-10-02', 1, 3),
(9, 'email', '2024-10-02', 1, 4),
(10, 'email', '2024-10-02', 1, 5),
(11, 'email', '2024-10-20', 1, 1),
(12, 'email', '2024-10-20', 1, 2),
(13, 'email', '2024-10-20', 1, 3),
(14, 'email', '2024-10-20', 1, 4),
(15, 'email', '2024-10-21', 1, 5),
(16, 'email', '2024-10-21', 1, 1),
(17, 'email', '2024-10-02', 1, 2),
(18, 'email', '2024-10-02', 1, 3),
(19, 'email', '2024-10-02', 1, 4),
(20, 'email', '2024-10-02', 1, 5);
