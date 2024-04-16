-- Copyright (C) ---Put here your own copyright and developer email---
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see https://www.gnu.org/licenses/.


CREATE TABLE llx_clienjoyholidays_clienjoyholidays
(
	-- BEGIN MODULEBUILDER FIELDS

    ref varchar(40) UNIQUE DEFAULT '(PROV)' NOT NULL,
    label varchar(160) NOT NULL ,
    amount double,
    fk_destination_country integer NOT NULL ,
    start_date datetime,
    return_date datetime,
    fk_travel_mod int,
    rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fk_user_creat integer NOT NULL,
    fk_user_modif integer,
    tms timestamp,
    date_creation datetime NOT NULL ,
    import_key varchar(14),
    status smallint DEFAULT 0 NOT NULL


    -- END MODULEBUILDER FIELDS
) ENGINE=innodb;
