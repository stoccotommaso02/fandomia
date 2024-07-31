Avviare con:
docker compose up

Il container mysql all'avvio esegue il dump denominato 'dump.sql'

Per generare un dump del database:
docker exec my-database sh -c 'exec mysqldump -u myuser -pmypassword mydatabase' > db_dumps/nomedump.sql

Per eseguire un wipe del database:
docker exec -it my-database mysql -u root -prootpassword -e "DROP DATABASE testdb; CREATE DATABASE testdb;"