CREATE TABLE IF NOT EXISTS todos (
    id INTEGER PRIMARY KEY autoincrement,
    active BOOLEAN NOT NULL CHECK (active IN (0, 1)) DEFAULT 1,
    priority BOOLEAN NOT NULL CHECK (priority IN (0, 1)) DEFAULT 0,
    body TEXT NOT NULL unique,
    created_at INTEGER(4) NOT NULL DEFAULT (STRFTIME('%s','now'))
);
