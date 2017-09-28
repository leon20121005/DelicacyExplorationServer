CREATE TABLE Comments
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    url VARCHAR(20) NOT NULL,
    address VARCHAR(20) NOT NULL,
    evaluation DECIMAL(3,1),
    created_at timestamp default now(),
    updated_at timestamp,
    shop_id INT NOT NULL,
    FOREIGN KEY(shop_id) REFERENCES Shops(id) ON DELETE CASCADE
);