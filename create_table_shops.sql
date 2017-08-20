CREATE TABLE Shops
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    evaluation DECIMAL(3,1),
    address VARCHAR(20) NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp
);