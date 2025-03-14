# Gallery with User Registration System

This project is a **web-based gallery application** developed as part of a Computer Science course. It focuses on implementing the **Model-View-Controller (MVC) architecture** in **PHP**, integrating **MongoDB** for database management, and using **JavaScript** for dynamic functionality. The application allows users to register, log in, upload photos, and save their favorite photos to a "cart."

---

## Features

1. **User Authentication**:
   - Users can register, log in, and securely authenticate their accounts.
   - Passwords are securely hashed for storage.

2. **Photo Upload**:
   - Users can upload photos to the gallery to share them with others.
   - Uploaded photos are stored in the database and displayed in the gallery.

3. **Save to Favorites**:
   - Users can save their favorite photos by adding them to their "cart."
   - Similar to an online shopping cart, users can view and manage their saved photos.

---

## Technologies Used

- **PHP**: Used for server-side scripting and implementing the MVC architecture.
- **MongoDB**: Integrated for efficient and scalable database management.
- **JavaScript**: Enhances user interactivity and provides dynamic features.
- **CSS**: Used for styling the frontend and creating a responsive design.

---

## Installation

To set up the project locally, follow these steps:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/m-sadkowski/Gallery-with-user-registrating-system.git
   cd Gallery-with-user-registrating-system
   ```

2. **Set Up MongoDB**:
   - Install MongoDB on your system: [MongoDB Installation Guide](https://docs.mongodb.com/manual/installation/).
   - Create a database and configure the connection in the PHP application.

3. **Configure PHP**:
   - Ensure PHP is installed on your system.
   - Update the database connection settings in the PHP configuration files.

4. **Run the Application**:
   - Start a local server (e.g., using `php -S localhost:8000`).
   - Open the application in your browser: `http://localhost:8000`.

---

## Usage

1. **User Registration**:
   - Navigate to the registration page and create an account.
   - Provide a username, email, and password.

2. **User Login**:
   - Log in using your registered credentials.

3. **Photo Upload**:
   - After logging in, navigate to the upload page.
   - Select a photo from your device and upload it to the gallery.

4. **Save to Favorites**:
   - Browse the gallery and click the "Add to Favorites" button on photos you like.
   - View your saved photos in the "Favorites" section.

---

## Screenshots

![Registration Page](screenshots/registration.png)
*User registration page.*

![Login Page](screenshots/login.png)
*User login page.*

![Gallery Page](screenshots/gallery.png)
*Gallery with uploaded photos.*

![Favorites Page](screenshots/favorites.png)
*Favorites section with saved photos.*

---

## Project Structure

The project follows the **MVC architecture**:

- **Model**: Handles data logic and interacts with MongoDB.
- **View**: Contains the frontend files (HTML, CSS, JavaScript).
- **Controller**: Manages user requests and updates the model and view.


## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Open a pull request.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Contact

For questions or feedback, please reach out to [m-sadkowski](https://github.com/m-sadkowski).

---

Enjoy sharing and saving your favorite photos! 📸