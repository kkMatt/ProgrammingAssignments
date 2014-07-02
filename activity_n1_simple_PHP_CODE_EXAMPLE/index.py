__author__ = 'Kestutis ITDev'
__date__ = '06/19/2011'
__version__ = '1.0'

# *********************************************************
# Functions

"""
 # Function for removing elements from A if they exist in B
 # @param array arrOriginal - original array (array A)
 # @param array arrComparing - array to compare with original (array B)
 # @return array - modified array
"""
def removeBothExistingElements(arrOriginal, arrComparing):
    # Copy arrays
    arrOriginalNew = arrOriginal[:]
    arrComparingNew = arrComparing[:]

    # Get total length
    totalLenOfOrgArray = len(arrOriginalNew)

    i = 0
    while i < totalLenOfOrgArray:
        elem = arrOriginalNew[i]
        if elem in arrComparingNew:
            # [COMPARING] Get an index of element in comparing array
            elemIndexInComparingArray = getIndexOfElementInArray(elem, arrComparingNew)
            # [ORIGINAL] Get an index of element in original array
            elemIndexInOriginalArray = getIndexOfElementInArray(elem, arrOriginalNew)

            # MiniDebug
            # print "."
            # print "found elem", str(elem)
            # print "index[org]:" + str(elemIndexInOriginalArray)
            # print "index[cmp]:" + str(elemIndexInComparingArray)

            # [COMPARING] Remove that element from comparing array
            removeElementAtIndexFromArray(elemIndexInComparingArray, arrComparingNew)
            # [ORIGINAL] Remove that element from original array
            removeElementAtIndexFromArray(elemIndexInOriginalArray, arrOriginalNew)

            # Decrement size of original new array
            totalLenOfOrgArray -= 1
        else:
            # Move to next element in the list
            i += 1

    return arrOriginalNew

"""
 # Function for getting index of specified element in array
 # @param array elem - element to search (might be an integer or an array (A => B)
 # @param array arrElemArray - array in which we will search for elem
 # @return int - element index in array, or false if element is not in array
"""
def getIndexOfElementInArray(elem, arrElemArray):
    # We know that it is a number OR a pair (A => B)
    if isinstance(elem, dict) and len(elem) == 2:
        ret = arrElemArray.index(elem[1])
    else:
        ret = arrElemArray.index(elem)

    return ret

"""
 # Function for removing element at specified index from array
 # @param int index - a element position in array
 # @param array &arrElemArray - a reference to array from which we will remove an element
"""
def removeElementAtIndexFromArray(index, arrElemArray):
    if isinstance(index, int) and index >= 0:
        try:
            # OK
            del arrElemArray[index]
        except NameError:
            #element was not set
            print "element at specified index do not exist"
            raise


# *********************************************************
# Test

# Input data - test no. 1
arrOfIntA = [2,3,4,4,4,5,10,11,14]
arrOfIntB = [1,2,3,3,4,4,9,9,10,12]
newArrayOfIntA = removeBothExistingElements(arrOfIntA, arrOfIntB)
# res 4,5,11,14

# Input data - test no. 2
arrOfStringA = ["aaa", "bbb", "eee", "eee", "fff", "ggg"]
arrOfStringB = ["bbb", "bbb", "ccc", "eee", "fff"]
newArrayOfStringA = removeBothExistingElements(arrOfStringA, arrOfStringB)
# res aaa, eee, ggg

# Output
print "\n[Int] Original array A (before):"
print arrOfIntA
print "\n[Int] Array B:"
print arrOfIntB
print "\n[Int] Modified array A (after):"
print newArrayOfIntA

print "\n"
print "\n[String] Original array A (before):"
print arrOfStringA
print "\n[String] Array B:"
print arrOfStringB
print "\n[String] Modified array A (after):"
print newArrayOfStringA
