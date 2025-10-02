add_executable(TestEncodeDecode
        ../../../src/Lab3/Stream/Input/FileInputStream.cpp
        ../../../src/Lab3/Stream/Output/FileOutputStream.cpp
        ../../../src/Lab3/Stream/Input/DecryptDecorator.cpp
        ../../../src/Lab3/Stream/Output/EncryptDecorator.cpp
        ../../../src/Lab3/Stream/Cipher/Cipher.cpp
        EncodeDecodeTest.cpp)


target_link_libraries(TestEncodeDecode PRIVATE Catch2::Catch2WithMain)
