create DATABASE doan;
use doan;
create table users(
    id int PRIMARY KEY AUTO_INCREMENT ,
    account char(20),
    username char(20),
    pass char(20)
);
insert into users(account,username,pass) VALUES
('1','Trương Nhật Anh','1'),
('2','Bùi Mạnh Tiến','2');
CREATE TABLE sanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gia DECIMAL(10, 2) NOT NULL,
    so_luong INT NOT NULL,
    img TEXT,
    ram VARCHAR(20),          
    rom VARCHAR(20),          
    chip VARCHAR(100),        
    man_hinh VARCHAR(50),     
    camera VARCHAR(50),       
    pin VARCHAR(50),
    brand varchar(50)
);
INSERT INTO sanpham (name, gia, so_luong, img, ram, rom, chip, man_hinh, camera, pin,brand) VALUES
('iPhone 14', 999.99, 50, '/doan/public/img/ip14.webp', '6GB', '128GB', 'A15 Bionic', '6.1 inches', '12MP + 12MP', '3279 mAh','Apple'),
('Samsung Galaxy S22', 799.99, 30, '/doan/public/img/samsungs22.webp', '8GB', '128GB', 'Exynos 2200', '6.1 inches', '50MP + 12MP + 10MP', '3700 mAh','Samsung'),
('Xiaomi Mi 11', 699.99, 20, '/doan/public/img/xiaomi11.webp', '8GB', '256GB', 'Snapdragon 888', '6.81 inches', '108MP + 13MP + 5MP', '4600 mAh','Xiaomi'),
('OnePlus 9', 729.99, 25, '/doan/public/img/oneplus-9_1.png', '8GB', '128GB', 'Snapdragon 888', '6.55 inches', '48MP + 50MP + 2MP', '4500 mAh','oneplus'),
('Iphone13', 599.99, 15, '/doan/public/img/IP13BLACK.webp', '8GB', '128GB', 'A14 Bionic', '6.1 inches', '50MP + 12MP', '4614 mAh','Apple'),
('Oppo Find X3 Pro', 1149.99, 10, '/doan/public/img/findx3.jpg', '12GB', '256GB', 'Snapdragon 888', '6.7 inches', '50MP + 50MP + 13MP + 3MP', '4500 mAh','Oppo'),
('iPhone 16', 1299.99, 8, '/doan/public/img/ip16.webp', '12GB', '256GB', 'A16 Bionic', '6.5 inches', '12MP + 12MP + 12MP', '4500 mAh', 'Apple'),
('Samsung Galaxy S23', 999.99, 10, '/doan/public/img/samsung_s23.jpg', '8GB', '256GB', 'Exynos 2200', '6.1 inches', '50MP + 12MP + 10MP', '3700 mAh', 'Samsung'),
('Xiaomi 13 Pro', 1099.99, 7, '/doan/public/img/xiaomi_13_pro.jpg', '12GB', '256GB', 'Snapdragon 8 Gen 2', '6.73 inches', '50MP + 50MP + 50MP', '4820 mAh', 'Xiaomi'),
('iPhone 15 Pro', 999.99, 12, '/doan/public/img/iphone15_pro.jpg', '8GB', '128GB', 'A16 Bionic', '6.1 inches', '48MP + 12MP', '3200 mAh', 'Apple'),
('Samsung Galaxy Z Flip 4', 999.99, 6, '/doan/public/img/samsung_z_flip4.jpg', '8GB', '256GB', 'Snapdragon 8+ Gen 1', '6.7 inches', '12MP + 12MP', '3700 mAh', 'Samsung'),
('Oppo Reno 8 Pro', 699.99, 15, '/doan/public/img/oppo_reno8_pro.jpg', '8GB', '256GB', 'Dimensity 8100-Max', '6.7 inches', '50MP + 8MP + 2MP', '4500 mAh', 'Oppo'),
('Xiaomi Redmi Note 11', 199.99, 20, '/doan/public/img/xiaomi_redmi_note11.jpg', '4GB', '128GB', 'Snapdragon 680', '6.43 inches', '50MP + 8MP + 2MP + 2MP', '5000 mAh', 'Xiaomi'),
('Samsung Galaxy A53', 349.99, 25, '/doan/public/img/samsung_a53.jpg', '6GB', '128GB', 'Exynos 1280', '6.5 inches', '64MP + 12MP + 5MP + 5MP', '5000 mAh', 'Samsung');
create table hoadon (
    id int AUTO_INCREMENT PRIMARY key ,
    iduser int ,
    idsp int ,
    foreign key (iduser) references users(id),
    foreign key (idsp) references sanpham(id)
);