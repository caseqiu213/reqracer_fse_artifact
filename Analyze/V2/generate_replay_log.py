from bind_gor_request import *
from entry import *
import os

print("\n\n")
request_idx_2_gor_filename = bind_request()

spk_edges = get_spk_edges()
rrr_groups = get_rrr_groups()
racing_request_id_pairs, request_order = get_racing_request_pairs()

print("SPK edges are: ")
print(spk_edges)
print("RRR groupds are: ")
print(rrr_groups)

racing_request_pairs = []
for i in racing_request_id_pairs:
	if i[0] not in request_order:
	    racing_request_pairs.append(sorted([request_order.index(i[0][:-1]), request_order.index(i[1])]))
	if i[1] not in request_order:
	    racing_request_pairs.append(sorted([request_order.index(i[0]), request_order.index(i[1][:-1])]))
	if i[0] in request_order and i[1] in request_order:
	    racing_request_pairs.append(sorted([request_order.index(i[0]), request_order.index(i[1])]))
print("Racing request pairs are: ")

remove = []
for pair in racing_request_pairs:
	if pair[0] not in request_idx_2_gor_filename or pair[1] not in request_idx_2_gor_filename:
		remove.append(pair)

temp = []
for pair in racing_request_pairs:
	if pair not in remove:
		temp.append(pair)
racing_request_pairs = temp
print(racing_request_pairs)
print(len(racing_request_pairs))

# for each racing request pair, find the RRR group it belongs to.
# then find SPK edge parent node belongs to which group
log1s = []
log2s = []

idx = 0
while idx < len(racing_request_pairs):
	pair = racing_request_pairs[idx]
	replay_log1 = set()
	replay_log2 = set()
	for group in rrr_groups:
		if pair[0] in group:
			for i in group:
				if i <= pair[0]:
					replay_log1.add(i)
		if pair[1] in group:
			for i in group:
				if i <= pair[1]:
					replay_log2.add(i)
	# print(replay_log1)
	# print(replay_log2)
	# print("----------------------------")
	log1s.append(replay_log1)
	log2s.append(replay_log2)
	idx += 1
assert len(log1s) == len(log2s), "logs1 and logs2 should have the same length"

print("The to-replay logs with request ids are: ")		
idx = 0
while idx < len(racing_request_pairs):
	group_used = []
	for edge in spk_edges:
		if pair[0] == edge[1]:
			for group in rrr_groups:
				if edge[0] in group:
					group_used.append(group)
					for i in group:
						log1s[idx].add(i)
		if pair[1] == edge[1]:
			for group in rrr_groups:
				if edge[0] in group and group not in group_used:
					for i in group:
						log2s[idx].add(i)
	print(log1s[idx])
	print(log2s[idx])
	print("----------------------------")
	idx += 1
assert len(log1s) == len(log2s), "logs1 and logs2 should have the same length"


replay1_dir_str = "../../Replay/replay1_logs/"
combine_cmd1s = []
counter = 0
while counter < len(log1s):
	log1 = log1s[counter]
	file1 = ""
	for entry in sorted(list(log1)):
		file1 += request_idx_2_gor_filename[entry] + " "
	# print(file1)
	combine_cmd1 = "cat " + file1 + " > " + replay1_dir_str + "replay1_req_" + str(racing_request_pairs[counter][0]) + "_req_" + str(racing_request_pairs[counter][1]) + ".log"
	# print(combine_cmd1)
	combine_cmd1s.append(combine_cmd1)
	counter += 1

replay2_dir_str = "../../Replay/replay2_logs/"
combine_cmd2s = []
counter = 0
while counter < len(log2s):
	log2 = log2s[counter]
	file2 = ""
	for entry in sorted(list(log2)):
		file2 += request_idx_2_gor_filename[entry] + " "
	# print(file2)
	combine_cmd2 = "cat " + file2 + " > " + replay2_dir_str + "replay2_req_" + str(racing_request_pairs[counter][0]) + "_req_" + str(racing_request_pairs[counter][1]) + ".log"
	# print(combine_cmd2)
	combine_cmd2s.append(combine_cmd2)
	counter += 1

print("Running command to generate replay logs...")

for cmd1 in combine_cmd1s:
	os.system(cmd1)

for cmd2 in combine_cmd2s:
	os.system(cmd2)

print("Replay logs are generated in \n" + replay1_dir_str + "\nand \n" + replay2_dir_str)

# use command date +%s%N to get current timestamp in ns

# start generate replay logs for duplicated requests
# replay_log1_dup will use rrr group and spk edge to generate
# replay_log1_dup only has self request
print("===================================================")
racing_request_id_pairs_dup, request_order = get_racing_request_pairs_dup()
racing_request_pairs_dup = []
for i in racing_request_id_pairs_dup:
	if i[0] not in request_order:
	    racing_request_pairs_dup.append(sorted([request_order.index(i[0][:-1]), request_order.index(i[1])]))
	if i[1] not in request_order:
	    racing_request_pairs_dup.append(sorted([request_order.index(i[0]), request_order.index(i[1][:-1])]))
	if i[0] in request_order and i[1] in request_order:
	    racing_request_pairs_dup.append(sorted([request_order.index(i[0]), request_order.index(i[1])]))
print("Racing request dup pairs are: ")

remove = []
for pair in racing_request_pairs_dup:
	if pair[0] not in request_idx_2_gor_filename or pair[1] not in request_idx_2_gor_filename:
		remove.append(pair)

temp = []
for pair in racing_request_pairs_dup:
	if pair not in remove:
		temp.append(pair)
racing_request_pairs_dup = temp
print(racing_request_pairs_dup)
print(len(racing_request_pairs_dup))

def get_racing_request_pairs_dup():
	return racing_request_pairs_dup

def get_racing_request_pairs():
	return racing_request_pairs

log1s_dup = []
log2s_dup = []

idx = 0
while idx < len(racing_request_pairs_dup):
	pair = racing_request_pairs_dup[idx]
	replay_log1_dup = set()
	log2s_dup.append([pair[0]])
	for group in rrr_groups:
		if pair[0] in group:
			for i in group:
				if i <= pair[0]:
					replay_log1_dup.add(i)

	log1s_dup.append(replay_log1_dup)
	idx += 1

idx = 0
print("The to-replay dup logs with request ids are:")
while idx < len(racing_request_pairs_dup):
	for edge in spk_edges:
		if pair[0] == edge[1]:
			for group in rrr_groups:
				if edge[0] in group:
					for i in group:
						log1s_dup[idx].add(i)
	print(log1s_dup[idx])
	# print("----------------------------")
	idx += 1

replay1_dir_str = "../../Replay/replay1_logs/"
combine_cmd1s = []
counter = 0
while counter < len(racing_request_pairs_dup):
	log1 = log1s_dup[counter]
	file1 = ""
	for entry in sorted(list(log1)):
		file1 += request_idx_2_gor_filename[entry] + " "
	# print(file1)
	combine_cmd1 = "cat " + file1 + " > " + replay1_dir_str + "replay1_dup_req_" + str(racing_request_pairs_dup[counter][0]) + "_req_" + str(racing_request_pairs_dup[counter][0]) + ".log"
	combine_cmd1s.append(combine_cmd1)
	counter += 1

replay2_dir_str = "../../Replay/replay2_logs/"
combine_cmd2s = []
counter = 0
while counter < len(racing_request_pairs_dup):
	file2 = ""
	file2 += request_idx_2_gor_filename[racing_request_pairs_dup[counter][1]] + " "
	# print(file2)
	combine_cmd2 = "cat " + file2 + " > " + replay2_dir_str + "replay2_dup_req_" + str(racing_request_pairs_dup[counter][0]) + "_req_" + str(racing_request_pairs_dup[counter][0]) + ".log"
	combine_cmd2s.append(combine_cmd2)
	counter += 1

print("Running command to generate replay logs...")

for cmd1 in combine_cmd1s:
	# print(cmd1)
	os.system(cmd1)

for cmd2 in combine_cmd2s:
	# print(cmd2)
	os.system(cmd2)

print("Replay logs(dup) are generated in \n" + replay1_dir_str + "\nand \n" + replay2_dir_str)
