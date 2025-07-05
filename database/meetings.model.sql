CREATE TABLE IF NOT EXISTS meetings (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid (),
    title varchar(225) NOT NULL,
    description text,
    meeting_date timestamp NOT NULL,
    duration_minutes integer,
    location varchar(225),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP
);