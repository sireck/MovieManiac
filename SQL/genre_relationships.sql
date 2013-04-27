--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: genre_relationships; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE genre_relationships (
    movie_id integer,
    genre_id integer
);


ALTER TABLE public.genre_relationships OWNER TO postgres;

--
-- Name: genre_relationships; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE genre_relationships FROM PUBLIC;
REVOKE ALL ON TABLE genre_relationships FROM postgres;
GRANT ALL ON TABLE genre_relationships TO postgres;
GRANT ALL ON TABLE genre_relationships TO teja;


--
-- PostgreSQL database dump complete
--

