-- Таблица для хранения пользователей
CREATE TABLE IF NOT EXISTS personal (
    id_personal INT AUTO_INCREMENT PRIMARY KEY,
    log VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Таблица для хранения продуктов
CREATE TABLE IF NOT EXISTS product (
    id_product INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    model VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    img MEDIUMBLOB NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Таблица для хранения заказов
CREATE TABLE IF NOT EXISTS order_customer (
    id_order INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    id_product INT NOT NULL,
    id_customer INT NOT NULL,
    FOREIGN KEY (id_product) REFERENCES product(id_product),
    FOREIGN KEY (id_customer) REFERENCES personal(id_personal)
);
