import codecs
import math

class fileReader:
	def __init__(self, file_path):
		self._file_path = file_path
		self._content = []
		self._count = 0

	def parse(self):
		with codecs.open(self._file_path, 'r', encoding='utf-8', errors='ignore') as f:
			all_text = f.readlines()
			self._content = all_text
		for line in all_text:
			self._count += 1
		
	def get_content(self):
		return self._content

	@property
	def count(self):
		return self._count

log_file = input ("Enter one log filename from replay1_logs folder: ")
fp = "./replay1_logs/" + log_file
fr = fileReader(fp)
fr.parse()
lines = fr.get_content()

# first line content
# print(lines[0].split(' ')[2])

# find last timestamp
index = len(lines)-1
while index > 0:
	if lines[index].startswith("1"):
		last_line = (lines[index])
		break
	index -= 1

output = int(last_line.split(' ')[2]) - int(lines[0].split(' ')[2])
print(math.ceil(output/1000000000))


