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
);
CREATE TABLE Blood_Bank (
    blood_bank_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    region VARCHAR(100),
    address VARCHAR(255),
    email VARCHAR(100),
    password VARCHAR(100)
);
CREATE TABLE Donation (8
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
CREATE TABLE Notification (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    notification_method VARCHAR(50),
    notification_date DATE,
    blood_bank_id INT,
    donor_id INT,
    FOREIGN KEY (blood_bank_id) REFERENCES Blood_Bank(blood_bank_id),
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id)
);
CREATE TABLE DonorNotification (
    donor_id INT,
    notification_id INT,
    PRIMARY KEY (donor_id, notification_id),
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id),
    FOREIGN KEY (notification_id) REFERENCES Notification(notification_id)
);
