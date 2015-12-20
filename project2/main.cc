/**
 * Copyright (C) 2008 by The Regents of the University of California
 * Redistribution of this file is permitted under the terms of the GNU
 * Public License (GPL).
 *
 * @author Junghoo "John" Cho <cho AT cs.ucla.edu>
 * @date 3/24/2008
 */
 
#include "Bruinbase.h"
#include "SqlEngine.h"
#include "BTreeNode.h"
#include "BTreeIndex.h"
#include <cstdio>
#include <iostream>
#include <cstring>

using namespace std;

int main()
{
	/*------------------------------BTLeafNode------------------------------*/
	// PageFile pf;
	// BTLeafNode b;
	// BTLeafNode s;
	// b.read(pf.endPid(), pf);
	
	// RecordId r1;
	// r1.pid = r1.sid = 1;
	// RecordId r2;
	// r2.pid = r2.sid = 2;
	// RecordId r3;
	// r3.pid = r3.sid = 3;
	// RecordId r4;
	// r4.pid = r4.sid = 4;
	// RecordId r5;
	// r5.pid = r5.sid = 5;
	// RecordId r6;
	// r6.pid = r6.sid = 6;
	// RecordId r7;
	// r7.pid = r7.sid = 7;
	// RecordId r8;
	// r8.pid = r8.sid = 8;
	// RecordId r9;
	// r9.pid = r9.sid = 9;
	// RecordId r10;
	// r10.pid = r10.sid = 10;
	
	
	// b.insert(1, r1);
	// b.insert(3, r3);
	// b.insert(5, r5);
	// b.insert(2, r2);
	// b.insert(8, r8);
	// b.insert(9, r9);
	// b.insert(10, r10);
	// b.insert(4, r4);
	// b.insert(6, r6);
	
	// cout << "Key count: "<< b.getKeyCount() << endl;
	// b.print();
	
	// int eid;
	// b.locate(8, eid);
	// cout << "locate 8 eid: " << eid << endl;
	// b.locate(-1, eid);
	// cout << "locate 100 eid: " << eid << endl;
	
	// int key;
	// RecordId rLast;
	// b.readEntry(2, key, rLast);
	// cout << "read entry key: " << key << " rid: " << rLast.pid << ", " << rLast.sid << endl;
	
	// cout << endl << "INSERT SPLIT" << endl<< endl;
	
	// int skey;
	// b.insertAndSplit(7, r7, s, skey);
	// cout << "b Key count: "<< b.getKeyCount() << endl;
	// b.print();
	// cout << "s Key count: "<< s.getKeyCount() << endl;
	// s.print();
	// cout << "skey: " << skey << endl;
	
	/*------------------------------BTNonLeafNode------------------------------*/
	// BTNonLeafNode nl;
	// BTNonLeafNode s;
	// PageFile pfile;
	// nl.read(pfile.endPid(), pfile);
	
	// PageId pids[10] = {1, 2, 3, 4, 5, 6, 7, 8, 9, 10};
	// nl.insert(8*2, pids[7]);
	// nl.insert(5*2, pids[4]);
	// nl.insert(3*2, pids[2]);
	// nl.insert(2*2, pids[1]);
	// nl.insert(9*2, pids[8]);
	// nl.insert(1*2, pids[0]);
	// nl.insert(4*2, pids[3]);
	// nl.insert(6*2, pids[5]);
	// nl.insert(7*2, pids[6]);
	
	// cout << "Key count: " << nl.getKeyCount() << endl;
	// nl.print();
	
	// PageId cptr = 0;
	// nl.locateChildPtr(1, cptr);
	// cout << "Child ptr: " << cptr << endl;
	
	// cout << endl << "INSERT SPLIT" << endl<< endl;

	// int skey;
	// nl.insertAndSplit(5, 11, s, skey);
	// cout << "b Key count: "<< nl.getKeyCount() << endl;
	// nl.print();
	// cout << "s Key count: "<< s.getKeyCount() << endl;
	// s.print();
	// cout << "skey: " << skey << endl;

	/*------------------------------BTreeIndex------------------------------*/
	
	/*
	int maxEid = (PageFile::PAGE_SIZE-sizeof(PageId))/(sizeof(RecordId)+sizeof(int)); //This produces 85
	cout << sizeof(PageFile) << endl;
	cout << sizeof(PageId) << endl;
	cout << sizeof(int) << endl;

	PageFile pf;
	pf.open("test", 'w');

	cout << "pf.endPid() on initialization: " << pf.endPid() << endl;

	//check for endPid changes
	BTLeafNode thisLeaf;
	for(int i=0; i<85; i++)
		thisLeaf.insert(1, (RecordId) {1,1});

	cout << "thisLeaf has key count: " << thisLeaf.getKeyCount() << endl;
	cout << "pf.endPid() after insert: " << pf.endPid() << endl;
		
	//Try inserting leaf node
	//If succesful, write back into PageFile
	cout << "thisLeaf write: " << thisLeaf.write(1, pf) << endl;
	cout << "pf.endPid() after thisLeaf write: " << pf.endPid() << endl;

	//Try inserting leaf node via splitting
	BTLeafNode anotherLeaf;
	int anotherKey;

	thisLeaf.insertAndSplit(2, (RecordId) {2,2}, anotherLeaf, anotherKey);

	cout << "thisLeaf has key count: " << thisLeaf.getKeyCount() << endl;
	cout << "anotherLeaf has key count: " << anotherLeaf.getKeyCount() << endl;

	cout << "pf.endPid() after insert and split: " << pf.endPid() << endl;

	//Write new contents into thisLeaf and anotherLeaf
	//Notice that anotherLeaf starts writing at the end of the last pid
	cout << "thisLeaf write: " << thisLeaf.write(1, pf) << endl;
	cout << "anotherLeaf write: " << anotherLeaf.write(2, pf) << endl;

	cout << "pf.endPid() after anotherLeaf write: " << pf.endPid() << endl;

	thisLeaf.setNextNodePtr(pf.endPid());

	cout << "pf.endPid() after setting thisLeaf's next node ptr: " << pf.endPid() << endl;

	pf.close();
	pf.open("test", 'r');

	BTLeafNode readTest;
	cout << "readTest: " << readTest.read(1, pf) << endl;
	BTLeafNode readTest2;
	cout << "readTest2: " << readTest2.read(2, pf) << endl;
	cout << "readTest has key count: " << readTest.getKeyCount() << endl;
	cout << "readTest2 has key count: " << readTest2.getKeyCount() << endl;
	*/
	
	/*  
	SOME test cases for read and write:
	1) write a leaf and read it
	2) write a leaf with a next pointer and read it
	3) write a non-leaf with X keys and X id's and read it
	- I assume we will never use a non-leaf with X keys and X id's based on how we create the tree though, so this test may be unnecessary
	4) write a non-leaf with X keys and X + 1 id's and read it
	5) write a root and read it

	SOME test cases for insert:
	1) insert into an empty tree
	2) insert into a tree without resulting in overflow
	3) insert into a tree resulting in leaf overflow
	4) insert into a tree resulting in non-leaf overflow
	5) insert into a tree resulting in having to create a new root
	*/
	
	/*
	cout << "Testing read/write for LeafNodes" << endl;

	PageFile pfRW;
	pfRW.open("testPFRW.idx", 'w');
	PageFile pfRW2;
	pfRW2.open("testPFRW2.idx", 'w');
	BTLeafNode lRW, lRW2;
	BTNonLeafNode nlRW, nlRW2;

	lRW.insert(1, (RecordId) {1,1}); 
	lRW.insert(2, (RecordId) {2,2}); 
	lRW.insert(3, (RecordId) {3,3}); 
	lRW.insert(4, (RecordId) {4,4}); 
	cout << lRW.insert(5, (RecordId) {5,5}) << endl;

	cout << "pfRW.endPid() on initialization: " << pfRW.endPid() << endl;
	cout << "lRW has #keys: " << lRW.getKeyCount() << endl;
	cout << lRW.write(1, pfRW) << endl;
	cout << "pfRW.endPid() after write: " << pfRW.endPid() << endl;

	int key1=-100;
	RecordId rid1;
	char bufferTest[PageFile::PAGE_SIZE];
	cout << pfRW.read(1, bufferTest) << endl;

	//This should produce 111222333444555
	for(int i=0; i<5; i++)
	{
		if(i==0)
		{
			memcpy(&key1, bufferTest, sizeof(int));
			memcpy(&rid1, bufferTest+4, sizeof(RecordId));
			cout << "key1 is: " << key1 << endl;
			cout << "pid1 is: " << rid1.pid << endl;
			cout << "sid1 is: " << rid1.sid << endl;
		}
		else
		{
			memcpy(&key1, bufferTest+(12*i), sizeof(int));
			memcpy(&rid1, bufferTest+4+(12*i), sizeof(RecordId));
			cout << "key1 is: " << key1 << endl;
			cout << "pid1 is: " << rid1.pid << endl;
			cout << "sid1 is: " << rid1.sid << endl;
		}
	}

	cout << lRW2.read(1, pfRW) << endl;
	cout << "lRW2 has #keys: " << lRW2.getKeyCount() << endl;

	int eid1=-100;
	for(int i=0; i<5; i++)
	{
		lRW2.locate(i+1, eid1);
		cout << "eid1 is: " << eid1 << endl;
	}

	//repeat the same thing for non leaf nodes
	cout << "Testing read/write for NonLeafNodes" << endl;

	nlRW.insert(1, 1); 
	nlRW.insert(2, 2); 
	nlRW.insert(3, 3); 
	nlRW.insert(4, 4); 
	cout << nlRW.insert(5, 5) << endl;

	cout << "pfRW2.endPid() on initialization: " << pfRW2.endPid() << endl;
	cout << "nlRW has #keys: " << nlRW.getKeyCount() << endl;
	cout << nlRW.write(1, pfRW2) << endl;
	cout << "pfRW2.endPid() after write: " << pfRW2.endPid() << endl;


	cout << nlRW2.read(1, pfRW2) << endl;
	cout << "nlRW2 has #keys: " << nlRW2.getKeyCount() << endl;
	*/
	
	/*
	  //Initialize new leaf node
	  BTLeafNode poop;
	  cout << "Initial key count: " << poop.getKeyCount() << endl;
	  
	  int zeroPls;
	  
	  //Try stuffing our node with (key, rid) pairs until node is full
	  //RecordId poopRid;
	  for(int i=0; i<86; i++)
	  {
		RecordId poopRid = {i,i+1};
		zeroPls = poop.insert(i+1, poopRid);
		cout << "Am I zero? " << zeroPls << endl;
	  }
		
	  cout << "Final key count: " << poop.getKeyCount() << endl;
		
	  poop.print();	
	  
	  //Test insertAndSplit by putting in a new (key, rid) pair
	  BTLeafNode poop2;
	  int poop2Key = -1;
	  poop.insertAndSplit(100, ((RecordId){101, 102}), poop2, poop2Key);
	  cout << "The first entry in poop2 has key (should be 5?): " << poop2Key << endl;
	  
	  cout << "poop has numKeys " << poop.getKeyCount() << " and poop2 has numKeys " << poop2.getKeyCount() << endl;
	  
	  //Nothing should change if we don't meet the conditions to split
	  zeroPls = poop.insertAndSplit(100, (RecordId){101, 102}, poop2, poop2Key);
	  cout << "poop has numKeys " << poop.getKeyCount() << " and poop2 has numKeys " << poop2.getKeyCount() << " (should be same)" << endl;
	  cout << "zeroPls should not be zero pls: " << zeroPls << endl;
	  
	  poop.print();
	  poop2.print();
	*/

	/*
	int key;

	BTLeafNode leaf;
	BTLeafNode siblingLeaf;

	for(int i=2; i<100; i++)
		leaf.insert(i, (RecordId){i,i});
		
	leaf.insertAndSplit(1, (RecordId){111,111}, siblingLeaf, key);

	cout << "MEDIAN KEY: " << key << endl;
	cout << "leaf's #keys: " << leaf.getKeyCount() << endl; 
	leaf.print();
	cout << "sibling leaf's #keys: " << siblingLeaf.getKeyCount() << endl; 
	siblingLeaf.print();

	cout << endl << endl;

	BTNonLeafNode nonLeaf;
	BTNonLeafNode siblingNonLeaf;

	for(int i=1; i<135; i++)
		nonLeaf.insert(i, i);
	cout << "nonLeaf's #keys: " << nonLeaf.getKeyCount() << endl;	

	nonLeaf.insertAndSplit(1111, 1111, siblingNonLeaf, key);
		
	cout << "KEY: " << key << endl;
	cout << "nonLeaf's #keys: " << nonLeaf.getKeyCount() << endl;
	nonLeaf.print();
	cout << "siblingNonLeaf's #keys: " << siblingNonLeaf.getKeyCount() << endl;
	siblingNonLeaf.print();
	*/

	/*
	IndexCursor c;

	BTreeIndex test;
	test.open("testIndex.idx", 'w');

	RC rc;
	for (int i=1; i<=32000; i++)
		if (rc = test.insert(i, (RecordId) {i, i}))
			cout << "Failed to insert " << i << endl;
		
	cout << endl;

	for (int i=1; i<=32000; i++)
	{
		// cout << "did it work: " << test.locate(i, c) << endl;
		if (test.locate(i, c))
			cout << "Failed to locate: " << i << endl;
		// cout << i << ": " << c.eid << " / " << c.pid << endl;
	}

	cout << "rootPid: " << test.getRootPid() << endl;
	cout << "treeHeight: " << test.getTreeHeight() << endl;
		
	test.close();
	*/
	
	// run the SQL engine taking user commands from standard input (console).
	SqlEngine::run(stdin);

  return 0;
}
