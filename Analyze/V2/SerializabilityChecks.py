import sys


def check_dict(ins1, ins2):
    dicts1 = ins1.get_dict()
    dicts2 = ins2.get_dict()
    for dict1 in dicts1:
        for dict2 in dicts2:
            for key1 in dict1:
                if key1 in dict2:
                    if dict1[key1] == dict2[key1]:
                        return True
    return False


def check_select_all(ins):
    if "SELECT *" in ins.get_query() and "WHERE" not in ins.get_query():
        return True
    if "SELECT" in ins.get_query() and "COUNT( * )" in ins.get_query():
        return True


def get_req_index(request_id, request_order):
    if request_id in request_order:
        return request_order.index(request_id)
    else:
        return len(request_order)


def print_info(ins, request_order):
    # print(ins.get_request_id())
    # print(get_req_index(ins.get_request_id(), request_order))
    # print(ins.get_query())
    # print(ins.get_query_id()+1)
    return


# (e|R)R'(A|W|D)(A'|W'|D')
def type1_check(req1, req2, request_order, bug, file_num, req1_list, req2_list, racing_instr, flag):
    local_file_num = 0
    req_list = req1_list + req2_list
    # print(len(racing_instr))
    check = 0
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        table = ins1.get_table_name()
        type1 = ins1.get_type()
        type2 = ins2.get_type()

        # if(ins1.get_request_id() == "XdXkjT6jvg6BwEALh8OxVwAAAJQ"):
        # 	print(ins1.get_type())
        # 	print("XXXXXXXXXXXXXXXXXXXXXXXX")
        # 	print(ins1.get_request_id())
        # 	print(ins1.get_query())
        # 	print(ins2.get_type())
        # 	print(ins2.get_request_id())
        # 	print(ins2.get_query())

        if type1 == "A" or type1 == "W" or type1 == "D":
            if type2 == "A" or type2 == "W" or type2 == "D":
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()

                # find R' only
                for ins_b in req2_list:
                    if ins_b.get_table_name() == table:
                        if ins_b.get_query_id() < index2:
                            if ins_b.get_type() == "R":
                                if check_select_all(ins_b):
                                    # assert ins1.get_request_id() != ins2.get_request_id(), "type1 check needs work"
                                    # print("====================")
                                    # print("1")
                                    # print("type1 check pass")
                                    print_info(ins_b, request_order)
                                    print_info(ins1, request_order)
                                    print_info(ins2, request_order)
                                    return True
                                if check_dict(ins1, ins_b):
                                    # assert ins1.get_request_id() != ins2.get_request_id(), "type1 check needs work"
                                    # print("====================")
                                    # print("2")
                                    # print("type1 check pass")
                                    # if request_order.index(ins1.get_request_id()) > request_order.index( ins2.get_request_id()):
                                    #     print_info(ins2, request_order)
                                    #     print_info(ins_b, request_order)
                                    #     print_info(ins1, request_order)
                                    # else:
                                    print_info(ins_b, request_order)
                                    print_info(ins1, request_order)
                                    print_info(ins2, request_order)
                                    return True
            # find RR'
            # for ins_a in req1_list:
            # 	for ins_b in req2_list:
            # 		if ins_a.get_table_name() == ins_b.get_table_name() == table:
            # 			if(ins_a.get_query_id() < index1 and ins_b.get_query_id() < index2):
            # 				if(ins_a.get_type() == ins_b.get_type() == "R"):
            # 					return True

            if type2 == "R":
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()

                # if(ins1.get_request_id() == "XdXklT6jvg6BwEALh8OxWgAAAJU"): #and ins2.get_request_id() == "2216"):
                # 	# if(ins1.get_type() == "A" and ins2.get_type() == "A"):
                # 	print("XXXXXXXXXXXXXXXXXXXXXXXX")
                # 	print(ins1.get_request_id())
                # 	print(ins1.get_query())
                # 	print(ins2.get_request_id())
                # 	print(ins2.get_query())

                # Now have R'(A|W|D)
                for ins_b in req_list:
                    if ins_b.get_table_name() == table and ins_b.get_request_id() == ins1.get_request_id():
                        if ins_b.get_query_id() > index1:
                            # find (A'|W'|D')
                            if ins_b.get_type() == "A" or ins_b.get_type() == "W" or ins_b.get_type() == "D":
                                if not flag:
                                    if ins_b.get_query() == ins1.get_query() and ins_b.get_type() == ins1.get_type() == "W":
                                        return False
                                if check_dict(ins2, ins_b):
                                    # print("====================")
                                    # print("3")
                                    # assert ins1.get_request_id() != ins2.get_request_id(), "type1 check needs work"
                                    # print("type1 check pass")
                                    # if request_order.index(ins1.get_request_id()) > request_order.index( ins2.get_request_id()):
                                    #     print_info(ins2, request_order)
                                    #     print_info(ins1, request_order)
                                    #     print_info(ins_b, request_order)
                                    # else:
                                    print_info(ins1, request_order)
                                    print_info(ins2, request_order)
                                    print_info(ins_b, request_order)
                                    return True
    return False

# A(A'|R'|W')A
def type2_check(req1, req2, request_order, bug, file_num, req1_list, req2_list, racing_instr, flag):
    local_file_num = 0
    req_list = req1_list + req2_list
    # print(len(racing_instr))
    check = 0
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        table = ins1.get_table_name()
        if 'mdl_sessions' in table:
            continue
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        type1 = ins1.get_type()
        type2 = ins2.get_type()
        if type1 == "A":
            if type2 == "A":
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()
                for ins in req_list:
                    if ins.get_request_id() == ins1.get_request_id():
                        if ins.get_query_id() != index1 and ins.get_table_name() == table:
                            if ins.get_type() == "A":
                                if check_dict(ins2, ins):
                                    # print("====================")
                                    # print("type2 check pass")
                                    # if ins1.get_query_id() < ins.get_query_id():
                                    #     print_info(ins1, request_order)
                                    #     print_info(ins2, request_order)
                                    #     print_info(ins, request_order)
                                    # if ins1.get_query_id() > ins.get_query_id():
                                    print_info(ins, request_order)
                                    print_info(ins2, request_order)
                                    print_info(ins1, request_order)
                                    return True
                    if ins.get_request_id() == req2:
                        if ins.get_query_id() != index2 and ins.get_table_name() == table:
                            if ins.get_type() == "A":
                                if check_dict(ins1, ins):
                                    # print("====================")
                                    # print("type2 check pass")
                                    # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                    # if ins2.get_query_id() < ins.get_query_id():
                                    #     print_info(ins2, request_order)
                                    #     print_info(ins1, request_order)
                                    #     print_info(ins, request_order)
                                    # if ins2.get_query_id() > ins.get_query_id():
                                    print_info(ins, request_order)
                                    print_info(ins1, request_order)
                                    print_info(ins2, request_order)
                                    return True
            if type2 == "R" or type2 == "W":
                index1 = ins1.get_query_id()
                for ins in req_list:
                    if ins.get_request_id() == ins1.get_request_id():
                        if ins.get_query_id() != index1 and ins.get_table_name() == table:
                            if ins.get_type() == "A":
                                if check_dict(ins2, ins):
                                    # print("====================")
                                    # print("type2 check pass")
                                    # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                    # if ins1.get_query_id() < ins.get_query_id():
                                    #     print_info(ins1, request_order)
                                    #     print_info(ins2, request_order)
                                    #     print_info(ins, request_order)
                                    # if ins1.get_query_id() > ins.get_query_id():
                                    print_info(ins, request_order)
                                    print_info(ins2, request_order)
                                    print_info(ins1, request_order)
                                    return True
    return False

# (e|W')W(A'|R')(W|A)
def type3_check(req1, req2, request_order, bug, file_num, req1_list, req2_list, racing_instr, flag):
    local_file_num = 0
    req_list = req1_list + req2_list
    # print(len(racing_instr))
    check = 0
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        table = ins1.get_table_name()
        if 'mdl_sessions' in table:
            continue
        type1 = ins1.get_type()
        type2 = ins2.get_type()

        if type2 == "A" and (type1 == "A" or type1 == "W"):
            index1 = ins1.get_query_id()
            index2 = ins2.get_query_id()
            for ins in req_list:
                if ins.get_table_name() == table:
                    if ins.get_query_id() != index1 and ins.get_type() == "W":
                        # print("====================")
                        # print("type3 check pass")
                        # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                        print_info(ins1, request_order)
                        print_info(ins, request_order)
                        print_info(ins2, request_order)
                        return True
        if type2 == "R":
            if type1 == "W":
                index1 = ins1.get_query_id()
                for ins_a in req1_list:
                    if ins_a.get_table_name() == table:
                        if ins_a.get_query_id() != index1 and ins_a.get_type() == "W":
                            if not flag:
                                if ins_a.get_query() == ins1.get_query() and ins_a.get_type() == ins1.get_type() == "W":
                                    return False
                            if check_dict(ins1, ins_a):
                                # print("====================")
                                # print("type3 check pass")
                                # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                      
                                print_info(ins1, request_order)
                                print_info(ins2, request_order)
                                print_info(ins_a, request_order)
                                return True
            if type1 == "A":
                index1 = ins1.get_query_id()
                for ins_a in req1_list:
                    if ins_a.get_table_name() == table:
                        if ins_a.get_query_id() < index1 and ins_a.get_type() == "W":
                            if not flag:
                                if ins_a.get_query() == ins1.get_query() and ins_a.get_type() == ins1.get_type() == "W":
                                    return False
                            if check_dict(ins1, ins_a):
                                # print("====================")
                                # print("type3 check pass")
                                # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                print_info(ins1, request_order)
                                print_info(ins2, request_order)
                                print_info(ins_a, request_order)
                                return True
    return False

# DD'AA'
def type4_check(req1, req2, request_order, bug, file_num, req1_list, req2_list, racing_instr, flag):
    local_file_num = 0
    # print(len(racing_instr))
    check = 0
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        table = ins1.get_table_name()
        if 'mdl_sessions' in table:
            continue
        type1 = ins1.get_type()
        type2 = ins2.get_type()
        if type1 == "D":
            if type2 == "D":
                # search for AA'
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()
                for ins_a in req1_list:
                    for ins_b in req2_list:
                        if ins_a.get_table_name() == ins_b.get_table_name() == table:
                            if ins_a.get_query_id() > index1 and ins_b.get_query_id() > index2:
                                if ins_a.get_type() == "A" and ins_b.get_type() == "A":
                                    if check_dict(ins1, ins_b) and check_dict(ins1, ins_a):
                                        # print("====================")
                                        # print("type4 check pass")
                                        # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                        print_info(ins1, request_order)
                                        print_info(ins2, request_order)
                                        print_info(ins_a, request_order)
                                        print_info(ins_b, request_order)
                                        return True
            if type2 == "A":
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()
                for ins_a in req1_list:
                    for ins_b in req2_list:
                        if ins_a.get_table_name() == ins_b.get_table_name() == table:
                            if ins_a.get_query_id() > index1 and ins_b.get_query_id() < index2:
                                if ins_a.get_type() == "A" and ins_b.get_type() == "D":
                                    # print(ins1.get_query())
                                    # print(ins2.get_query())
                                    # print(ins_a.get_query())
                                    # print(ins_b.get_query())
                                    if check_dict(ins1, ins_b) and check_dict(ins1, ins_a):
                                        # print("====================")
                                        # print("type4 check pass")
                                        # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                        print_info(ins1, request_order)
                                        print_info(ins2, request_order)
                                        print_info(ins_a, request_order)
                                        print_info(ins_b, request_order)
                                        return True
        if type1 == "A":
            if type2 == "D":
                # search for AA'
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()
                for ins_a in req1_list:
                    for ins_b in req2_list:
                        if ins_b.get_table_name() == ins_a.get_table_name() == table:
                            if ins_a.get_query_id() < index1 and ins_b.get_query_id() > index2:
                                if ins_a.get_type() == "D" and ins_b.get_type() == "A":
                                    # print(ins1.get_query())
                                    # print(ins2.get_query())
                                    # print(ins_a.get_query())
                                    # print(ins_b.get_query())
                                    if check_dict(ins1, ins_b) and check_dict(ins1, ins_a):
                                        # print("====================")
                                        # print("type4 check pass")
                                        print_info(ins1, request_order)
                                        print_info(ins2, request_order)
                                        print_info(ins_a, request_order)
                                        print_info(ins_b, request_order)
                                        return True
            if type2 == "A":
                index1 = ins1.get_query_id()
                index2 = ins2.get_query_id()
                for ins_a in req1_list:
                    for ins_b in req2_list:
                        if ins_a.get_table_name() == ins_b.get_table_name() == table:
                            if ins_a.get_query_id() < index1 and ins_b.get_query_id() < index2:
                                if ins_a.get_type() == "D" and ins_b.get_type() == "D":
                                    # print(ins1.get_query())
                                    # print(ins2.get_query())
                                    # print(ins_a.get_query())
                                    # print(ins_b.get_query())
                                    if check_dict(ins1, ins_b) and check_dict(ins1, ins_a):
                                        # print("====================")
                                        # print("type4 check pass")
                                    
                                        # assert request_order.index(ins1.get_request_id()) < request_order.index(ins2.get_request_id()), "request1 is after request2"
                                    
                                        print_info(ins1, request_order)
                                        print_info(ins2, request_order)
                                        print_info(ins_a, request_order)
                                        print_info(ins_b, request_order)
                                        
                                        return True
    return False

# AD'R
def type5_check(req1, req2, req1_list, req2_list, racing_instr):
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        table = ins1.get_table_name()
        type1 = ins1.get_type()
        type2 = ins2.get_type()
        if type1 == "A" and type2 == "D":
            index1 = ins1.get_query_id()
            for ins_a in req1_list:
                if ins_a.get_table_name() == table:
                    if ins_a.get_query_id() > index1 and ins_a.get_type() == "R":
                        return True
        if type1 == "D" and type2 == "R":
            index2 = ins2.get_query_id()
            for ins_b in req2_list:
                if ins_b.get_table_name() == table:
                    if ins_b.get_query_id() < index2 and ins_b.get_type() == "A":
                        return True
    return False


# RA'R
def type6_check(req1, req2, req1_list, req2_list, racing_instr):
    req_list = req1_list + req2_list
    for pair in racing_instr:
        ins1 = pair[0]
        ins2 = pair[1]
        # assert ins1.get_table_name() == ins2.get_table_name(), "table name not the same"
        table = ins1.get_table_name()
        type1 = ins1.get_type()
        type2 = ins2.get_type()
        if type1 == "A" and type2 == "R":
            index2 = ins2.get_query_id()
            for ins_b in req2_list:
                if ins_b.get_table_name() == table:
                    if ins_b.get_query_id() != index2 and ins_b.get_type() == "R":
                        return True
    return False
