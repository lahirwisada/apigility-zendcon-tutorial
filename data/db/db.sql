DROP TABLE IF EXISTS speakers;
CREATE TABLE speakers (
  id INTEGER PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  url VARCHAR(255),
  twitter VARCHAR(80)
);

DROP TABLE IF EXISTS talks;
CREATE TABLE talks (
  id INTEGER PRIMARY KEY,
  title TEXT,
  abstract TEXT,
  day TEXT,
  start_time TEXT
);

DROP TABLE IF EXISTS talks_speakers;
CREATE TABLE talks_speakers (
  talk_id INTEGER NOT NULL,
  speaker_id INTEGER NOT NULL
);
