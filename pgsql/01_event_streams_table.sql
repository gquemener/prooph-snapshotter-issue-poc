--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: event_streams; Type: TABLE; Schema: public; Owner: dev; Tablespace: 
--

CREATE TABLE event_streams (
    no bigint NOT NULL,
    real_stream_name character varying(150) NOT NULL,
    stream_name character(41) NOT NULL,
    metadata jsonb,
    category character varying(150)
);


ALTER TABLE event_streams OWNER TO dev;

--
-- Name: event_streams_no_seq; Type: SEQUENCE; Schema: public; Owner: dev
--

CREATE SEQUENCE event_streams_no_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE event_streams_no_seq OWNER TO dev;

--
-- Name: event_streams_no_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dev
--

ALTER SEQUENCE event_streams_no_seq OWNED BY event_streams.no;


--
-- Name: no; Type: DEFAULT; Schema: public; Owner: dev
--

ALTER TABLE ONLY event_streams ALTER COLUMN no SET DEFAULT nextval('event_streams_no_seq'::regclass);


--
-- Data for Name: event_streams; Type: TABLE DATA; Schema: public; Owner: dev
--

COPY event_streams (no, real_stream_name, stream_name, metadata, category) FROM stdin;
1	my_aggregate-my_only_aggregate	_d2a20e10f1e7b0ae2bbb0dcbd5b854e440c56fcf                       	[]	my_aggregate
\.


--
-- Name: event_streams_no_seq; Type: SEQUENCE SET; Schema: public; Owner: dev
--

SELECT pg_catalog.setval('event_streams_no_seq', 1, false);


--
-- Name: event_streams_pkey; Type: CONSTRAINT; Schema: public; Owner: dev; Tablespace: 
--

ALTER TABLE ONLY event_streams
    ADD CONSTRAINT event_streams_pkey PRIMARY KEY (no);


--
-- Name: event_streams_stream_name_key; Type: CONSTRAINT; Schema: public; Owner: dev; Tablespace: 
--

ALTER TABLE ONLY event_streams
    ADD CONSTRAINT event_streams_stream_name_key UNIQUE (stream_name);


--
-- Name: event_streams_category_idx; Type: INDEX; Schema: public; Owner: dev; Tablespace: 
--

CREATE INDEX event_streams_category_idx ON event_streams USING btree (category);


--
-- PostgreSQL database dump complete
--

