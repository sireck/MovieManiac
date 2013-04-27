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
-- Name: reviews; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE reviews (
    review_id integer NOT NULL,
    movie_id bigint,
    critic_name character varying(300),
    date date,
    freshness character varying(30),
    publication character varying(300),
    quote text
);


ALTER TABLE public.reviews OWNER TO postgres;

--
-- Name: reviews_review_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE reviews_review_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviews_review_id_seq OWNER TO postgres;

--
-- Name: reviews_review_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE reviews_review_id_seq OWNED BY reviews.review_id;


--
-- Name: reviews_review_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('reviews_review_id_seq', 159723, true);


--
-- Name: review_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY reviews ALTER COLUMN review_id SET DEFAULT nextval('reviews_review_id_seq'::regclass);


--
-- Name: reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (review_id);


--
-- Name: reviews; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE reviews FROM PUBLIC;
REVOKE ALL ON TABLE reviews FROM postgres;
GRANT ALL ON TABLE reviews TO postgres;
GRANT ALL ON TABLE reviews TO teja;


--
-- Name: reviews_review_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE reviews_review_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reviews_review_id_seq FROM postgres;
GRANT ALL ON SEQUENCE reviews_review_id_seq TO postgres;
GRANT ALL ON SEQUENCE reviews_review_id_seq TO teja;


--
-- PostgreSQL database dump complete
--

