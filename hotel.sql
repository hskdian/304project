create table customer
    (phone char(12) not null,
    name varchar(20) not null,
    age int not null,
    street varchar(90) not null,
    zipcode char(7) not null,
    primary key (phone));
    
    
create table zipcodecitystate
    (zipcode char(7) not null,
    city varchar(20) not null,
    state varchar(20) not null,
    primary key(zipcode));
