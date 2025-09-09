CREATE TABLE libros (
    id INT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    anio_publicacion INT,
    paginas INT,
    ejemplares_disponibles INT,
    fecha_creacion DATETIME,
    fecha_actualizacion DATETIME
);

INSERT INTO libros (id, isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles, fecha_creacion, fecha_actualizacion) VALUES
(1,  '9780140449136', 'El Quijote', 'Miguel de Cervantes', 1605, 863, 5, '2022-05-15 10:30:00', '2023-06-20 14:45:00'),
(2,  '9780061120084', 'To Kill a Mockingbird', 'Harper Lee', 1960, 281, 3, '2022-07-22 09:15:00', '2023-08-25 16:30:00'),
(3,  '9780747532743', 'Harry Potter and the Philosopher''s Stone', 'J.K. Rowling', 1997, 223, 7, '2023-01-10 11:00:00', '2023-12-12 12:00:00'),
(4,  '9780451524935', '1984', 'George Orwell', 1949, 328, 4, '2022-03-05 08:20:00', '2023-04-10 10:40:00'),
(5,  '9780307269997', 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 2011, 443, 6, '2022-11-18 14:50:00', '2023-12-19 15:55:00'),
(6,  '9780435127471', 'The Catcher in the Rye', 'J.D. Salinger', 1951, 277, 2, '2023-02-25 13:35:00', '2023-11-30 17:45:00'),
(7,  '9780072878191', 'The Hobbit', 'J.R.R. Tolkien', 1937, 310, 8, '2022-06-30 07:25:00', '2023-07-15 09:00:00'),
(8,  '9780525555377', 'Becoming', 'Michelle Obama', 2018, 448, 5, '2022-09-12 10:10:00', '2023-10-22 18:20:00'),
(9,  '9780553380163', 'A Song of Ice and Fire: A Game of Thrones', 'George R.R. Martin', 1996, 694, 3, '2023-03-08 15:45:00', '2023-09-20 20:30:00'),
(10, '9780744939601', 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 1999, 435, 3, '2022-04-14 06:55:00', '2022-04-14 06:55:00'),
(11, '9780140449189', 'Cien años de soledad', 'Gabriel García Márquez', 2005, 234, 43, '2025-05-14 19:55:44', '2025-05-14 19:55:44'),
(12, '9780140449145', 'Deadpool3', 'Lobenzo', 2005, 95, 1, '2025-05-14 20:08:09', '2025-05-14 20:08:09'),
(15, '9780140449146', 'Bodas de sangre', 'Federico García Lorca', 1931, 345, 5, '2025-05-14 20:08:09', '2025-05-14 20:08:09');
