'''
Finished

provide interface of my dictionary
'''

class MyDict(dict):
    def __init__(self):
        self = dict()

    def add(self, key, value):
        if key in self:
            self[key].append(value)
        else:
            self[key] = [value]

class RequestDict(dict):
	def __init__(self):
		self = dict()

	def add(self, key, value):
		self[key] = value

	def update_value(self, key):
		self[key] += 1
