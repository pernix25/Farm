create database cowFarm;
use cowFarm;

create table cow_types(
	type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_desc varchar(16)
);

create table cows (
	cow_id INT AUTO_INCREMENT PRIMARY KEY,
    cow_type_id INT,
    FOREIGN KEY (cow_type_id) REFERENCES cow_types(type_id)
);

create table cow_numbers(
	cow_id INT NOT NULL,
    cow_number INT NOT NULL,
    PRIMARY KEY (cow_id, cow_number),
    FOREIGN KEY (cow_id) REFERENCES cows(cow_id)
);

create table medications(
	medication_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_name varchar(50),
    doses_per_bottle INT
);

create table medications_purchased(
	purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT,
    purchase_date DATE,
    purchase_price DECIMAL(6,2),
    num_of_bottles_purchased INT,
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
);

create table transaction_types(
	transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_desc varchar(50)
);

create table auction_info(
	auction_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_date DATE,
    num_cows_purchased INT,
    total_weight INT,
    total_price DECIMAL(8,2),
    transaction_id INT,
    FOREIGN KEY (transaction_id) REFERENCES transaction_types(transaction_id)
);

create table cow_to_auciton(
	record_id INT AUTO_INCREMENT PRIMARY KEY,
	cow_id INT,
    auction_id INT,
    FOREIGN KEY (cow_id) REFERENCES cows(cow_id),
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
    FOREIGN KEY (cow_id) REFERENCES cows(cow_id),
    FOREIGN KEY (state_id) REFERENCES cow_states(state_id)
);

create table doctoring(
	record_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT,
    doeses INT,
    event_id INT,
    FOREIGN KEY (event_id) REFERENCES cow_events(event_id),
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
);

create table babies(
	record_id INT AUTO_INCREMENT PRIMARY KEY,
    parent_cow_id INT,
    child_cow_id INT,
    FOREIGN KEY (parent_cow_id) REFERENCES cows(cow_id),
    FOREIGN KEY (child_cow_id) REFERENCES cows(cow_id)
);

create table notes(
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    cow_id INT,
    note_text TEXT,
    note_date DATE,
    cow_state INT,
    FOREIGN KEY (cow_id) REFERENCES cows(cow_id),
    FOREIGN KEY (cow_state) REFERENCES cow_states(state_id)
);
