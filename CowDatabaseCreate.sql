create database cowFarm;
use cowFarm;

create table cows (
	id INT AUTO_INCREMENT PRIMARY KEY,
    gender ENUM('Bull','Steer','Heifer','Cow') NOT NULL DEFAULT 'Heifer'
);

create table cow_numbers(
	cow_id INT NOT NULL,
    cow_number INT NOT NULL,
    PRIMARY KEY (cow_id, cow_number),
    FOREIGN KEY (cow_id) REFERENCES cows(id)
);

create table medications(
	medication_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_name varchar(50),
    doses_per_bottle INT,
    price_per_bottle DECIMAL(6,2)
);

create table medications_purchased(
	purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT,
    purchase_date DATE,
    num_of_bottles_purchased INT,
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
);

create table auction_info(
	auction_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_date DATE,
    num_cows_purchased INT,
    total_weight INT,
    total_price DECIMAL(8,2),
    transaction_type ENUM('Bought', 'Sold')
);

create table cow_to_auciton(
	record_id INT AUTO_INCREMENT PRIMARY KEY,
	cow_id INT,
    auction_id INT,
    FOREIGN KEY (cow_id) REFERENCES cows(id),
    FOREIGN KEY (auction_id) REFERENCES auction_info(auction_id)
);

create table cow_states(
	state_id INT AUTO_INCREMENT PRIMARY KEY,
    state_desc varchar(50)
);

create table cow_events(
	event_id INT AUTO_INCREMENT PRIMARY KEY,
	cow_id INT,
    state_id INT,
    event_date DATE,
    FOREIGN KEY (cow_id) REFERENCES cows(id),
    FOREIGN KEY (state_id) REFERENCES cow_states(state_id)
);

create table doctoring(
	record_id INT AUTO_INCREMENT PRIMARY KEY,
    cow_id INT,
    medication_id INT,
    doeses INT,
    administration_date DATE,
    FOREIGN KEY (cow_id) REFERENCES cows(id),
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
);
