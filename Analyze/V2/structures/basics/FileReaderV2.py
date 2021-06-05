import codecs

ROW_DELIMITER = 'PID'
FIELD_DELIMITER = '. '
KV_DELIMITER = ': '

def _parse_line(line):
	entry = {}
	line = line.strip().strip('.')
	for field in line.split(FIELD_DELIMITER):
		try:
			key, value = field.split(KV_DELIMITER)
			value = ' '.join(value.split())
			entry[key] = value
		except:
			pass
	return entry

class FileReader:
	def __init__(self, file_path):
		self._file_path = file_path
		self._content = []

	def read_another(self, file_path):
		self._file_path = file_path

	def parse(self):
		with codecs.open(self._file_path, 'r', encoding='utf-8', errors='ignore') as f:
			all_text = f.read().replace('\n', ' ')
		all_text = all_text.split(ROW_DELIMITER)[1:]
		all_text = [ROW_DELIMITER + line for line in all_text]
		if 'token' not in self._file_path:
			print("#Acc:")
			print(len(all_text))
		for line in all_text:
			if("l10n_cache" in line):
				continue
			self._content += [_parse_line(line)]

	def get_content(self):
		return self._content

	@property
	def count(self):
		return len(self._content)

# testing
# fp = "../../../logs/69815_token.log"
# fr = FileReader(fp)
# fr.parse()
# for i in (fr.get_content()):
# 	print(i)