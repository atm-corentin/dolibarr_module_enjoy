CREATE TABLE llx_c_transport_mod (
                                      rowid     integer AUTO_INCREMENT PRIMARY KEY,
                                      entity    integer	DEFAULT 1 NOT NULL,	-- multi company id
                                      code      varchar(3) NOT NULL,
                                      label     varchar(255) NOT NULL,
                                      active    tinyint DEFAULT 1  NOT NULL
) ENGINE=innodb;
