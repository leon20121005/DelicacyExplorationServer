CREATE TABLE Thumbnails
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(250) NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp,
    shop_id INT NOT NULL,
    FOREIGN KEY(shop_id) REFERENCES Shops(id) ON DELETE CASCADE
);