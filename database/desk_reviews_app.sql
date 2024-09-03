drop table if exists manufacturer;
create table manufacturer (    
    id integer not null primary key autoincrement,    
    name varchar(255) not null
); 
insert into manufacturer values (null, "Secretlab");
insert into manufacturer values (null, "Desky");
insert into manufacturer values (null, "Omnidesk");
insert into manufacturer values (null, "Ikea");
insert into manufacturer values (null, "Officeworks");

drop table if exists item;
create table item (    
    id integer not null primary key autoincrement,
    manufacturer_id int not null,
    name varchar(255) not null,
    foreign key (manufacturer_id) references manufacturer(id) on delete cascade
); 
insert into item values (null, 1, "Secretlab MAGNUS Pro Desk");
insert into item values (null, 1, "Secretlab MAGNUS Metal Desk");
insert into item values (null, 2, "Desky Solid Timber Desk");
insert into item values (null, 3, "Desky Dual Sit Stand Desk");
insert into item values (null, 3, "Omnidesk Wildwood");
insert into item values (null, 3, "Omnidesk Pro");
insert into item values (null, 4, "Bekant Desk");
insert into item values (null, 4, "Skarsta Sit and Stand Desk");
insert into item values (null, 4, "Linnmon Desk");
insert into item values (null, 5, "Stilford S2 Pro Electric Height Adjustable Desk");
insert into item values (null, 5, "J. Burrows Matrix Desk");

drop table if exists review;
create table review (    
    id integer not null primary key autoincrement,
    item_id int not null,
    name varchar(255) not null,
    rating int not null,
    review text not null,
    created_at datetime default current_timestamp,
    foreign key (item_id) references item(id)
);

insert into review (id, item_id, name, rating, review) values (null, 1, "Manish", 5, "What a desk; it has everything I need!");
insert into review (id, item_id, name, rating, review) values (null, 1, "Mandy", 5, "I like it as well.");
insert into review (id, item_id, name, rating, review) values (null, 1, "Sam", 5, "All rounder desk, this desk is all you need.");
insert into review (id, item_id, name, rating, review) values (null, 2, "Adam", 3, "The pro version is far better than the metal version.");
insert into review (id, item_id, name, rating, review) values (null, 5, "Sam", 5, "My every day desk, I love it.");
insert into review (id, item_id, name, rating, review) values (null, 6, "Mark", 2, "Overrated, I do not find it sturdy and good build quality.");
insert into review (id, item_id, name, rating, review) values (null, 8, "Mandy", 5, "Not bad, not bad at all.");
insert into review (id, item_id, name, rating, review) values (null, 9, "Gregory", 4, "Does the job, I am happy with it.");