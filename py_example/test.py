import unittest
from hello import *

class HelloTest(unittest.TestCase):

	def test_hello(self):
		name = 'Sagrario'
		expected = 'Hello, Sagrario!'

		result = hello_world(name)

		self.assertEqual(result, expected)
