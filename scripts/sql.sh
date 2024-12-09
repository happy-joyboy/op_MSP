#!/bin/bash

DB_NAME="xss_demo"
DB_NAME_USERS="users"
CHARSET="utf8"
DB_USER="root"
DB_PASSWORD=""

# Start MySQL service
sudo service mysql start

# Function to create the databases, user, and tables
create_databases_and_tables() {
  echo "Creating new MySQL database '${DB_NAME}' with character set '${CHARSET}'..."
  $MYSQL_CMD -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} DEFAULT CHARACTER SET ${CHARSET};"
  echo "Database '${DB_NAME}' successfully created!"

  echo "Creating new user '${DB_USER}'..."
  $MYSQL_CMD -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';"
  echo "User '${DB_USER}' successfully created!"

  echo "Granting ALL privileges on '${DB_NAME}' to '${DB_USER}'..."
  $MYSQL_CMD -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
  $MYSQL_CMD -e "FLUSH PRIVILEGES;"
  echo "Privileges granted. Setup complete!"

  echo "Creating table 'comments' in database '${DB_NAME}'..."
  $MYSQL_CMD -e "USE ${DB_NAME};
    CREATE TABLE IF NOT EXISTS comments (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100),
      comment TEXT,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );"
  echo "Table 'comments' successfully created in database '${DB_NAME}'."

  echo "Creating new MySQL database '${DB_NAME_USERS}' with character set '${CHARSET}'..."
  $MYSQL_CMD -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME_USERS} DEFAULT CHARACTER SET ${CHARSET};"
  echo "Database '${DB_NAME_USERS}' successfully created!"

  echo "Granting ALL privileges on '${DB_NAME_USERS}' to '${DB_USER}'..."
  $MYSQL_CMD -e "GRANT ALL PRIVILEGES ON ${DB_NAME_USERS}.* TO '${DB_USER}'@'localhost';"
  $MYSQL_CMD -e "FLUSH PRIVILEGES;"
  echo "Privileges granted. Setup complete!"

  echo "Creating table 'userdata' in database '${DB_NAME_USERS}'..."
  $MYSQL_CMD -e "USE ${DB_NAME_USERS};
    CREATE TABLE IF NOT EXISTS userdata (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(45) NOT NULL,
      email VARCHAR(45) NOT NULL,
      password VARCHAR(45) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    INSERT INTO userdata (id, username, email, password) VALUES
    (1, 'levi', 'levi@survey_corps.com', 'TheBadBoy_aka_titanSlayer')
    ON DUPLICATE KEY UPDATE username=username;"
  echo "Table 'userdata' successfully created and populated in database '${DB_NAME_USERS}'."
}

# Prompt for MySQL root password
echo "Please enter root user MySQL password!"
echo "Note: password will be hidden when typing"
read -rs rootpasswd

# Set MySQL command with root credentials
MYSQL_CMD="sudo mysql -uroot -p${rootpasswd}"

# Execute the function
create_databases_and_tables

echo "MySQL databases, user, and tables setup complete!"
