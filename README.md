# Gubru online gradebook

## About the Application
The Gubru application is an online gradebook. It is an ideal tool for students, teachers, and school principals. It allows for:
- Creating multiple classes
- Assigning teachers and students to classes
- Checking attendance
- Adding and viewing grades
- Viewing grade averages
- Contacting teachers, students, and the principal via build-in mail system
- Checking the latest announcements
- Downloading school files
- Checking homework assignments
- Viewing upcoming events, such as tests and quizzes

## Note⚠️
This program was written as a high school project in 2019. It contains many bugs and poorly understandable code. Since then, I have learned a lot about creating websites and web applications with better security, and I am sharing this project only as proof of work.

## File Translations
Since I did not think ahead, the files are in Polish. Below are their translations along with a brief description:

| Original File Name     | Translation              | Description                                     |
|------------------------|--------------------------|-------------------------------------------------|
| dodajKlase.html        | addClass.html            | Form for adding a new class                     |
| frekwencja.html        | attendance.html          | Displays attendance records                     |
| recive.html            | receive.html             | Hub for teachers and principal                  |
| dodajKonto.html        | addAccount.html          | Form for adding a new account                   |
| klasa.html             | class.html               | Overview of a specific class                    |
| sprawdzFrekwencje.html | checkAttendance.html     | Form for checking attendance                    |
| dodajOgloszenie.html   | addAnnouncement.html     | Form for adding a new announcement              |
| logout.html            | logout.html              | Logout page                                     |
| terminarz.html         | calendar.html            | Calendar view                                   |
| dodajPlik.html         | addFile.html             | Form for adding a new file                      |
| ogloszenia.html        | announcements.html       | List of announcements                           |
| wiadomosc.html         | message.html             | Message view                                    |
| dodajPrzedmiot.html    | addSubject.html          | Form for adding a new subject                   |
| panel.html             | panel.html               | Main page                                       |
| wyslane.html           | sent.html                | Outbox for sent messages                        |
| edytujNauczycieli.html | editTeachers.html        | Form for editing teachers                       |
| panelAdmin.html        | adminPanel.html          | Admin panel                                     |
| wysylanie.html         | sending.html             | Form for sending messages                       |
| edytujPrzedmioty.html  | editSubjects.html        | Form for editing subjects                       |
| plikiSzkoly.html       | schoolFiles.html         | List of school files                            |
| edytujUczniow.html     | editStudents.html        | Form for editing students                       |
| poczta.html            | mail.html                | Mail interface (inbox)                          |
| zadania.html           | homework.html            | List of homeworks                               |

## Website Demo
A demo of the website can be found in the `docs` folder and is available [here](https://mblazejczyk.github.io/Gubru-gradebook/).

## Files
The `srv38973_dziennik.sql` file is an export from phpMyAdmin, and the `website` folder contains the original website files - they just need to be connected to the database.
