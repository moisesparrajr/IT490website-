#!/usr/bin/env python
import pika
import sys

credentials = pika.PlainCredentials('adam','adam')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.2', 5672, '/', credentials))
channel = connection.channel()

channel.queue_declare(queue='test', durable= False)

message = ' '.join(sys.argv[1:]) or "Hello World!"
channel.basic_publish(exchange = '',
			routing_key='test',
			body=message, 
			properties=pika.BasicProperties(
				delivery_mode = 2, #make message persistent
			))

print(" [x] Sent %r" % message)
connection.close()
