#!/usr/bin/env python
import pika

credentials = pika.PlainCredentials('adam','adam')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.2', 5672, '/', credentials))
channel = connection.channel()

channel.queue_declare(queue='test')

channel.basic_publish(exchange='',
		routing_key='test',
		body='Hello World!')

print(" [X] Sent 'Hello World!'")

connection.close()
