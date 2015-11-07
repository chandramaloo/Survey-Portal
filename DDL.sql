create table users
	(
		user_id varchar(20) primary key,
		password varchar(30) not null,
		name varchar(30) not null,
		department varchar(30) not null,
		year numeric(4,0),
		email varchar(50) not null
		);

create table form
	(
		form_id varchar(45) primary key,
		start_time timestamp,
		end_time timestamp,
		anonymity char(1) check (anonymity in ('0','1')),
		form_name varchar(20)
		);

create table role
	(
		form_id varchar(45),
		user_id varchar(20),
		privilege char(1) check (privilege in ('0','1')),
		status char(1) check (status in ('0','1')),
		primary key (form_id,user_id,privilege),
		foreign key (form_id) references form(form_id),
		foreign key (user_id) references users(user_id),
		constraint privilege_status check ((privilege ='1' and status = '0') or privilege = '0')
		);

create table survey_questions
	(
		form_id varchar(45),
		question_id char(10),
		type char(1),
		default_answer varchar(20),
		is_compulsory char(1),
		content varchar(1000),
		extra_content varchar(1000),
		primary key (form_id,question_id),
		foreign key (form_id) references form(form_id));

create table survey_responses
	(
		form_id varchar(45),
		question_id char(10),
		user_id varchar(20),
		response varchar(1000),
		primary key (form_id,question_id,user_id),
		foreign key (form_id,question_id) references survey_questions,
		foreign key (user_id) references users(user_id));

create table images
	(
		id varchar(20) primary key,
		data bytea
		);

-- create table classroom
-- 	(building		varchar(15),
-- 	 room_number		varchar(7),
-- 	 capacity		numeric(4,0),
-- 	 primary key (building, room_number)
-- 	);

-- create table department
-- 	(dept_name		varchar(20), 
-- 	 building		varchar(15), 
-- 	 budget		        numeric(12,2) check (budget > 0),
-- 	 primary key (dept_name)
-- 	);

-- create table course
-- 	(course_id		varchar(8), 
-- 	 title			varchar(50), 
-- 	 dept_name		varchar(20),
-- 	 credits		numeric(2,0) check (credits > 0),
-- 	 primary key (course_id),
-- 	 foreign key (dept_name) references department
-- 		on delete set null
-- 	);

-- create table instructor
-- 	(ID			varchar(5), 
-- 	 name			varchar(20) not null, 
-- 	 dept_name		varchar(20), 
-- 	 salary			numeric(8,2) check (salary > 29000),
-- 	 primary key (ID),
-- 	 foreign key (dept_name) references department
-- 		on delete set null
-- 	);

-- create table section
-- 	(course_id		varchar(8), 
--          sec_id			varchar(8),
-- 	 semester		varchar(6)
-- 		check (semester in ('Fall', 'Winter', 'Spring', 'Summer')), 
-- 	 year			numeric(4,0) check (year > 1701 and year < 2100), 
-- 	 building		varchar(15),
-- 	 room_number		varchar(7),
-- 	 time_slot_id		varchar(4),
-- 	 primary key (course_id, sec_id, semester, year),
-- 	 foreign key (course_id) references course
-- 		on delete cascade,
-- 	 foreign key (building, room_number) references classroom
-- 		on delete set null
-- 	);

-- create table teaches
-- 	(ID			varchar(5), 
-- 	 course_id		varchar(8),
-- 	 sec_id			varchar(8), 
-- 	 semester		varchar(6),
-- 	 year			numeric(4,0),
-- 	 primary key (ID, course_id, sec_id, semester, year),
-- 	 foreign key (course_id,sec_id, semester, year) references section
-- 		on delete cascade,
-- 	 foreign key (ID) references instructor
-- 		on delete cascade
-- 	);

-- create table student
-- 	(ID			varchar(5), 
-- 	 name			varchar(20) not null, 
-- 	 dept_name		varchar(20), 
-- 	 tot_cred		numeric(3,0) check (tot_cred >= 0),
-- 	 primary key (ID),
-- 	 foreign key (dept_name) references department
-- 		on delete set null
-- 	);

-- create table takes
-- 	(ID			varchar(5), 
-- 	 course_id		varchar(8),
-- 	 sec_id			varchar(8), 
-- 	 semester		varchar(6),
-- 	 year			numeric(4,0),
-- 	 grade		        varchar(2),
-- 	 primary key (ID, course_id, sec_id, semester, year),
-- 	 foreign key (course_id,sec_id, semester, year) references section
-- 		on delete cascade,
-- 	 foreign key (ID) references student
-- 		on delete cascade
-- 	);

-- create table advisor
-- 	(s_ID			varchar(5),
-- 	 i_ID			varchar(5),
-- 	 primary key (s_ID),
-- 	 foreign key (i_ID) references instructor (ID)
-- 		on delete set null,
-- 	 foreign key (s_ID) references student (ID)
-- 		on delete cascade
-- 	);

-- create table time_slot
-- 	(time_slot_id		varchar(4),
-- 	 day			varchar(1),
-- 	 start_hr		numeric(2) check (start_hr >= 0 and start_hr < 24),
-- 	 start_min		numeric(2) check (start_min >= 0 and start_min < 60),
-- 	 end_hr			numeric(2) check (end_hr >= 0 and end_hr < 24),
-- 	 end_min		numeric(2) check (end_min >= 0 and end_min < 60),
-- 	 primary key (time_slot_id, day, start_hr, start_min)
-- 	);

-- create table prereq
-- 	(course_id		varchar(8), 
-- 	 prereq_id		varchar(8),
-- 	 primary key (course_id, prereq_id),
-- 	 foreign key (course_id) references course
-- 		on delete cascade,
-- 	 foreign key (prereq_id) references course
-- 	);

