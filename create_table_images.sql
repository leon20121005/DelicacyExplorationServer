CREATE TABLE Images
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
	image BLOB NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp,
    shop_id INT NOT NULL,
    FOREIGN KEY(shop_id) REFERENCES Shops(id) ON DELETE CASCADE
);