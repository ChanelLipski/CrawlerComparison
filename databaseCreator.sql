CREATE TABLE Downloaded(
    uri TEXT PRIMARY KEY,
    domain TEXT,
    download_time TIMESTAMP,
    code SMALLINT,
    document TEXT,
    finished BOOLEAN DEFAULT FALSE
);

CREATE TABLE Robots(
    uri TEXT,
    DOMAIN TEXT PRIMARY KEY)
);

CREATE TABLE Seen(
    uri TEXT PRIMARY KEY
);
/*
CREATE TABLE Whitelist(
    DOMAIN TEXT PRIMARY KEY
);
*/
