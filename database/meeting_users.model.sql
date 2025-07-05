CREATE TABLE IF NOT EXISTS meeting_users (
    meeting_id uuid NOT NULL REFERENCES meetings (id),
    user_id uuid NOT NULL REFERENCES users (id),
    PRIMARY KEY (meeting_id, user_id)
);