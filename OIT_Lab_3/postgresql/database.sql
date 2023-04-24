CREATE TABLE quizes
(
    quiz_id serial PRIMARY key,
    name text NOT NULL,
    description text NOT NULL,
    uid text UNIQUE NOT NULL,
    is_private boolean NOT NULL
);
CREATE TABLE answers
(
    answer_id serial PRIMARY key,
    quiz_id integer NOT NULL,
    answer text NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizes (quiz_id)
);
CREATE TABLE answers_data
(
    answer_data_id serial PRIMARY key,
    answer_id integer NOT NULL,
    ip text NOT NULL,
    answer_time timestamp NOT NULL,
    FOREIGN KEY (answer_id) REFERENCES answers (answer_id)
);