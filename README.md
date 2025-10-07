# School Management System

The **School Management System** is a sophisticated digital platform designed to meet the specific needs of educational institutions. It integrates 4 distinct panels — **Student**, **Teacher**, **Admin**, and **Parent** — each offering unique functionalities to streamline operations, enhance communication, and foster collaboration among stakeholders in the school community.

## Features

### Student Panel 

The **Student Panel** provides students with access to essential academic and personal information. Key features include:

- **Personal Dashboard**: View personal details, academic records, timetable, and upcoming assignments.
- **Attendance Tracking**: Check attendance records and receive notifications for absences.
- **Gradebook**: Access grades for assessments, exams, and overall academic performance.
- **Assignments and Homework**: Submit assignments online, view deadlines, and receive feedback from teachers.
- **Announcements**: Stay updated with school announcements, events, and important notices.

### Teacher Panel

The **Teacher Panel** empowers educators with tools for efficient classroom management and student assessment. Key features include:

- **Class Management**: Create and manage class schedules, attendance, and seating arrangements.
- **Grade Management**: Enter and update grades, generate progress reports, and analyze student performance.
- **Assignment Management**: Assign and distribute homework, projects, and assessments electronically.
- **Communication**: Communicate with students and parents through messaging and announcements.
- **Resource Sharing**: Share educational resources, lesson plans, and supplementary materials.

### Admin Panel

The **Admin Panel** serves as the backbone of the system, providing comprehensive oversight and administrative control. Key features include:

- **User Management**: Manage user accounts, roles, permissions, and access levels.
- **Data Management**: Maintain student records, academic calendars, and institutional data.
- **Finance Management**: Monitor fee payments, generate invoices, and track financial transactions.
- **Report Generation**: Generate and analyze various reports on attendance, academic performance, and administrative metrics.
- **System Configuration**: Configure system settings, customize workflows, and manage integrations.

### Parent Panel

The **Parent Panel** enables parents and guardians to actively participate in their child’s education and stay informed about their progress. Key features include:

- **Student Progress**: View academic grades, attendance records, and performance reports.
- **Communication**: Communicate with teachers and school administration through messaging and notifications.
- **Attendance Notifications**: Receive real-time updates on student attendance and absences.
- **Fee Management**: View fee schedules, make online payments, and track payment history.
- **Calendar and Events**: Access school calendars, upcoming events, and important dates.

## How it Works

The **School Management System** facilitates seamless collaboration and communication among students, teachers, administrators, and parents, enhancing efficiency, transparency, and overall educational outcomes within the institution.

## Installation

To set up the **School Management System** using **XAMPP**, follow the steps below:

### 1. Install XAMPP

**XAMPP** is a free and open-source cross-platform web server solution stack package. It includes Apache Server, SSMS, PHP, and Perl.

#### Step-by-Step Installation of XAMPP:

1. **Download XAMPP**:
   - Go to the [XAMPP official website] (https://www.apachefriends.org/download.html).
   - Select the version suitable for your operating system (Windows, macOS, or Linux).

2. **Install XAMPP**:
   - Run the downloaded installer.
   - Follow the on-screen instructions to install XAMPP.
   - Once installed, open the **XAMPP Control Panel**.

3. **Start Apache and MySQL**:
   - Open the **XAMPP Control Panel**.
   - Start the **Apache** service by clicking the `Start` button next to it.

### 2. Create Project Folder in `htdocs`

The `htdocs` folder is the root directory where your web projects will reside in XAMPP.

#### Steps to create the project folder:

1. **Navigate to the `htdocs` directory**:
   - Open the **XAMPP installation directory** (usually `C:\xampp` on Windows).
   - Locate and open the `htdocs` folder (`C:\xampp\htdocs`).

2. **Create your project folder**:
   - Inside the `htdocs` folder, create a new directory for your project:
     ```bash
     mkdir "School Management System"
     ```
   - You can name your project folder whatever you like, but in this case, we’ll use `School Management System`.

3. **Place your project files**:
   - Copy your **School Management System** project files into the `School Management System` folder.

### 3. Clone the Repository into the Project Folder

1. **Navigate to the project folder**:
   ```bash
   cd C:\xampp\htdocs\School%20Management%20System
   
2. **Clone the repository:**

   ```bash
   git clone https://github.com/yourUsername/School-Management-System.git .
  
### 4. Set up the Database 

If your project uses Microsoft SQL Server Management Studio (SSMS), you need to configure the database.

1. **Open SQL Server Management Studio (SSMS)**
  1. Launch SSMS and connect to your SQL Server instance using your authentication details.

  **Note**:- If SQl Server instance was not created previously, please follow the link (https://www.prisma.io/dataguide/mssql/setting-up-a-local-sql-server-database) and complete the mentioned steps at first, before proceeding with the Database Setup steps.

2. **Create a New Database**
  1. In Object Explorer, right-click on **Databases** and select **New Database**.
  2. Enter a name for the database (e.g., `DBSchool`) and click **OK** to create the database.

3. **Import the Database Bakup File**
  1. Navigate to project directory /School Management System/DBSchool.bak:
   - Select the newly created database & right click on that.
   - Navigate to Tasks > Restore > Database. This will open the Restore Database dialog box.
   - On the **General** page, the name of your empty database will already be populated in the **To Database** field.
   - In the **Source** section, select **Device**.
   - Click the **ellipsis (...)** button to the right of the Device box to open the **Select backup devices** dialog.
   - In the **Select backup devices** dialog, click the **Add** button.
   - Navigate to and select your backup file (with a .bak extension).
   - Click **OK** to add the backup device, and then **OK** again to return to the Restore Database dialog.
   - Check the box for **Overwrite the existing database (WITH REPLACE)**. This is the crucial step that tells SSMS to replace the empty database with the data from your backup file.
   - Under the **Restore the database files as** grid, you can verify or change the file paths for the .mdf and .ldf files. If you are moving the database to a new server or location, you will likely need to update these paths.
   - Click **OK** to begin the restore.

## Access the Project

- **Student Panel:**  
  `http://localhost/School%20Management%20System/Student`

- **Teacher Panel:**  
  `http://localhost/School%20Management%20System/Teacher`

- **Admin Panel:**  
  `http://localhost/School%20Management%20System/Admin`

- **Parent Panel:**  
  `http://localhost/School%20Management%20System/Parent`

## Test Credentials
**Login URL:** `http://localhost/School%20Management%20System/login.php`

- #### Admin Panel
  
  - **Username:** `admin@example.com`  
  - **Password:** `admin@sms`