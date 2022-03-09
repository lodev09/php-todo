CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY autoincrement,
    active BOOLEAN NOT NULL CHECK (active IN (0, 1)) DEFAULT 1,
    priority BOOLEAN NOT NULL CHECK (priority IN (0, 1)) DEFAULT 0,
    completed BOOLEAN NOT NULL CHECK (completed IN (0, 1)) DEFAULT 0,
    body TEXT NOT NULL,
    created_at INTEGER NOT NULL DEFAULT (STRFTIME('%s','now'))
);
