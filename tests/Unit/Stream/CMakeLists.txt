add_executable(TestStream
        ../../../src/Lab3/Stream/Input/FileInputStream.cpp
        ../../../src/Lab3/Stream/Output/FileOutputStream.cpp
        StreamTest.cpp)

add_executable(
        TestEncode
        ../../../src/Lab3/Stream/Cipher/Cipher.cpp
        ../../../src/Lab3/Stream/Output/FileOutputStream.cpp
        ../../../src/Lab3/Stream/Output/EncryptDecorator.cpp
        EncodeTest.cpp)

add_executable(
        TestDecode
        ../../../src/Lab3/Stream/Cipher/Cipher.cpp
        ../../../src/Lab3/Stream/Input/FileInputStream.cpp
        ../../../src/Lab3/Stream/Input/DecryptDecorator.cpp
        DecodeTest.cpp)

target_link_libraries(TestStream PRIVATE Catch2::Catch2WithMain)
target_link_libraries(TestEncode PRIVATE Catch2::Catch2WithMain)
target_link_libraries(TestDecode PRIVATE Catch2::Catch2WithMain)
