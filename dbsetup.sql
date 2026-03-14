CREATE TABLE states (
  id bigint NOT NULL GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  name varchar(255),
  abbreviation varchar(2)
);

CREATE TABLE county_cities (
  id bigint NOT NULL GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  county_name varchar(120),
  zip varchar(10),
  city_name varchar(120),
  state_id bigint,
  FOREIGN KEY(state_id) REFERENCES states(id)
);