# How to run the Hospital Management System

To run the system you need to have [XAMPP](https://www.apachefriends.org/) (PHP Development Environment) installed on your computer.

## Enabling SQLite in XAMPP

Make sure that SQLite is enabled as an extension. To check this, follow the steps below:

- Click on the `Config` button on the row labelled `Apache`
- Click on `PHP (php.ini)`, which will open up the `php.ini` file in a text file viewer
- Use `CTRL + F` or locate the `Find` option in your text file viewer, and search for `sqlite3`
- You should find a line of text that says `;extension=sqlite3` (if there is no semicolon, you already have SQLite enabled)
- Remove the semicolon from the text so that it says `extension=sqlite3`
- Save your change and close the document

## How to run the program

- Click on the `Explorer` button in the XAMMP menu
- Click on the folder called `htdocs`
- Move (or copy) the folder called `hospital-management-system` into the `htdocs` folder
- Click on the `Start` button on the row labelled `Apache` in the XAMPP menu
- Go to a web browser and type [localhost/hospital-management-system/index.html](http://localhost/hospital-management-system/index.html) (if you followed the instructions correctly, the link should work)


## Help! I accidentally logged myself out! D:

- Not to worry - we have a (very secure) working login that you can use!

### Username: `hms_admin`

### Password: `admin`
