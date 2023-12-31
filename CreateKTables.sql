DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Contributor;
DROP TABLE IF EXISTS KaraokeFile;
DROP TABLE IF EXISTS Song;

CREATE TABLE Song (
  SongID INT(15) UNIQUE PRIMARY KEY,
  Title CHAR(40) NOT NULL,
  Artist CHAR(40) NOT NULL
);

CREATE TABLE KaraokeFile (
  SongID INT(15) NOT NULL,
  FileID INT(15) UNIQUE PRIMARY KEY,
  Year INT(4) NOT NULL,
  Genre CHAR(40) NOT NULL,
  Version CHAR(40) NOT NULL,
  
  FOREIGN KEY(SongID) REFERENCES Song(SongID)
);

CREATE TABLE Contributor (
  ContributionID INT(15) UNIQUE PRIMARY KEY,
  FileID INT(15),
  Role CHAR(40) NOT NULL,
  ContributorName CHAR(40) NOT NULL,
  
  FOREIGN KEY(FileID) REFERENCES KaraokeFile(FileID)
);

CREATE TABLE User (
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  UserName CHAR(40) NOT NULL,
  FileID INT(15),
  
  FOREIGN KEY(FileID) REFERENCES KaraokeFile(FileID)
);
