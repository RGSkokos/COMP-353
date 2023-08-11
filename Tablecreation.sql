CREATE TABLE Ministries (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Facilities (
  fID INT PRIMARY KEY,
  type VARCHAR(100),
  description VARCHAR(255),
  facilityName VARCHAR(255),
  address VARCHAR(255),
  city VARCHAR(100),
  province VARCHAR(100),
  postalCode VARCHAR(20),
  phoneNumber VARCHAR(20),
  webAddr VARCHAR(255),
  capacity INT
);

CREATE TABLE part_Of (
  fID INT,
  name VARCHAR(255),
  PRIMARY KEY (fID,name),
  FOREIGN KEY (fID) REFERENCES Facilities(fID),
  FOREIGN KEY (name) REFERENCES Ministries(name)
);

CREATE TABLE People (
  medicareID INT PRIMARY KEY,
  firstName VARCHAR(100),
  lastname VARCHAR(100),
  dOB DATE,
  MedicareExpiryDate DATE,
  phone VARCHAR(20),
  address VARCHAR(255),
  city VARCHAR(100),
  province VARCHAR(100),
  postalCode VARCHAR(20),
  email VARCHAR(255)
);

CREATE TABLE Students (
  medicareID INT PRIMARY KEY,
  FOREIGN KEY (medicareID) REFERENCES People(medicareID)
);

CREATE TABLE Employee (
  medicareID INT PRIMARY KEY,
  jobTitle VARCHAR(255),
  FOREIGN KEY (medicareID) REFERENCES People(medicareID)
);

CREATE TABLE attends (
  fID INT,
  medicareID INT,
  startDate DATE,
  endDate DATE,
  occupation VARCHAR(255),
  PRIMARY KEY (fID, medicareID, startDate),
  FOREIGN KEY (fID) REFERENCES Facilities(fID),
  FOREIGN KEY (medicareID) REFERENCES People(medicareID)
	
);

CREATE TABLE Vaccines (
  vID INT PRIMARY KEY,
  vaccineName VARCHAR(100)
);


CREATE TABLE Viruses(
vID INT PRIMARY KEY,
type VARCHAR(100)
);

CREATE TABLE vaccinations (
  vID INT,
  medicareID INT,
  numDose INT,
  date DATE,
  PRIMARY KEY (vID, medicareID, numDose),	
  FOREIGN KEY (vID) REFERENCES Vaccines(vID),
  FOREIGN KEY (medicareID) REFERENCES People(medicareID)
);
CREATE TABLE infections (
  vID INT,
  medicareID INT,
  date DATE,
  PRIMARY KEY (vID, medicareID),
  FOREIGN KEY (vID) REFERENCES Viruses(vID),
  FOREIGN KEY (medicareID) REFERENCES People(medicareID));
  
  CREATE TABLE schedule (
  fID INT,
  medicareID INT,
  date DATE,
  startTime Time,
  endTime Time,
  PRIMARY KEY (fID, medicareID, date),
  FOREIGN KEY (fID) REFERENCES Facilities(fID),
  FOREIGN KEY (medicareID) REFERENCES Employee(medicareID));
  
  CREATE TABLE emailLogs (
  emailID INT,
  dateOfEmail DATE,
  receiverEmail VARCHAR(255),
  emailBody VARCHAR(80),
  PRIMARY KEY (emailID));
  
CREATE TABLE sent (
  emailID INT,
  fID INT,
  medicareID INT,
  PRIMARY KEY (emailID,fID, medicareID),
  FOREIGN KEY (emailID) REFERENCES emailLogs(emailID),
  FOREIGN KEY (fID) REFERENCES Facilities(fID),
  FOREIGN KEY (medicareID) REFERENCES Employee(medicareID)
   );
