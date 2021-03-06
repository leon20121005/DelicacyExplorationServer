CREATE TABLE Shops
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL UNIQUE,
    evaluation DECIMAL(3,1),
    address VARCHAR(40) NOT NULL,
    latitude FLOAT(10, 6) NOT NULL,
    longitude FLOAT(10, 6) NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp
);