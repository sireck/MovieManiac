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
-- Name: genre; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE directors (
    id integer NOT NULL,
    director_name character varying(300)
);


ALTER TABLE public.genre OWNER TO postgres;

--
-- Name: directors; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE directors FROM PUBLIC;
REVOKE ALL ON TABLE directors FROM postgres;
GRANT ALL ON TABLE directors TO postgres;
GRANT ALL ON TABLE directors TO teja;
