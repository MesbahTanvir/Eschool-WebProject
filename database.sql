CREATE TABLE user_table (
    user_id INT(10) NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) ,
    password_hash VARCHAR(100),
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    attempt INT,
    success INT,
    gender ENUM('Male', 'Female', 'Others' , ''),
    PRIMARY KEY (user_id)
);
CREATE TABLE subject_table (
    subject_id INT(10) NOT NULL AUTO_INCREMENT,
    subject_name VARCHAR(100) NOT NULL,
	subject_code VARCHAR(20) NOT NULL,
	UNIQUE(subject_code),
    PRIMARY KEY (subject_id)
);
CREATE TABLE chapter_table(
	chapter_id INT(10) NOT NULL AUTO_INCREMENT,
	chapter_name VARCHAR(100) NOT NULL,
	subject_code VARCHAR(20) NOT NULL,
	PRIMARY KEY(chapter_id),
	FOREIGN KEY (subject_code) REFERENCES subject_table(subject_code)
)
CREATE TABLE topic_table(
	topic_id INT(10) NOT NULL AUTO_INCREMENT,
	topic_name VARCHAR(100) NOT NULL,
	chapter_id INT(10) NOT NULL,
	PRIMARY KEY (topic_id),
	FOREIGN KEY (chapter_id) REFERENCES chapter_table(chapter_id)
)

CREATE TABLE mcq_table (
	mcq_id INT(10) NOT NULL AUTO_INCREMENT,
	question VARCHAR(1000) NOT NULL,
	option_a VARCHAR(50) NOT NULL,
	option_b VARCHAR(50) NOT NULL,
	option_c VARCHAR(50) NOT NULL,
	option_d VARCHAR(50) NOT NULL,
	correct_option VARCHAR(50) NOT NULL,
	PRIMARY KEY (mcq_id)
)

CREATE TABLE chapter_mcq_table(
	chapter_mcq_id INT(10) NOT NULL AUTO_INCREMENT,
	chapter_id INT(10) NOT NULL,
	mcq_id INT(10) NOT NULL,
	FOREIGN KEY (chapter_id) REFERENCES chapter_table(chapter_id),
	FOREIGN KEY (mcq_id) REFERENCES mcq_table(mcq_id),
	PRIMARY KEY(chapter_mcq_id)
)
CREATE TABLE subject_mcq_table(
	subject_mcq_id INT(10) NOT NULL AUTO_INCREMENT,
	subject_code VARCHAR(20) NOT NULL,
	mcq_id INT(10) NOT NULL,
	FOREIGN KEY (subject_code) REFERENCES subject_table(subject_code),
	FOREIGN KEY (mcq_id) REFERENCES mcq_table(mcq_id),
	PRIMARY KEY(subject_mcq_id)
)
CREATE TABLE exam_table(
	exam_id INT(10) NOT NULL AUTO_INCREMENT,
	user_id INT(10) ,
	FOREIGN KEY (user_id) REFERENCES user_table(user_id),
	PRIMARY KEY(exam_id)
)
CREATE TABLE exam_mcq_table(
	exam_mcq_id INT(10) NOT NULL AUTO_INCREMENT,
	exam_id INT(10) NOT NULL,
	mcq_id INT(10) NOT NULL,
	FOREIGN KEY (exam_id) REFERENCES exam_table(exam_id),
	FOREIGN KEY (mcq_id) REFERENCES mcq_table(mcq_id),
	PRIMARY KEY (exam_mcq_id)
)
CREATE TABLE topic_mcq_table(
	topic_mcq_id INT(10) NOT NULL AUTO_INCREMENT,
	topic_id INT(10) NOT NULL,
	mcq_id INT(10) NOT NULL,
	FOREIGN KEY (topic_id) REFERENCES topic_table(topic_id),
	FOREIGN KEY (mcq_id) REFERENCES mcq_table(mcq_id),
	PRIMARY KEY(topic_mcq_id)
)
CREATE TABLE mcq_submission_table (
	mcq_submission_id INT(10) NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    mcq_id INT(10) NOT NULL,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    answer TINYINT,
   	PRIMARY KEY (mcq_submission_id),
    FOREIGN kEY (user_id) REFERENCES user_table(user_id),
    FOREIGN KEY (mcq_id) REFERENCES mcq_table (mcq_id)
 )
 
 
CREATE TABLE admin_table (
    admin_id INT(10) NOT NULL AUTO_INCREMENT ,
	email VARCHAR(100) NOT NULL,
	password_hash VARCHAR(100) NOT NULL,
	first_name VARCHAR(50),
	last_name VARCHAR(50),
	qeustion_added int(10) DEFAULT 0,
    PRIMARY KEY (admin_id)
); 


