#include <iostream>
#include <fstream>
#include <sstream>

int main(int argc, char **argv)
{
	if (argc < 2) {
		std::cerr << "Usage: afromcsv file" << std::endl;
		return 0;
	}

	std::ifstream in(argv[1]);
	std::string buffer;
	size_t ct = 1;
	std::ofstream out;

	while (getline(in, buffer, '\n')) {
		std::ostringstream oss;
		oss << ct++ << ".a.txt";
		out.open(oss.str().c_str(), std::ios::trunc);
		out << buffer;
		out.close();
	}

	return 0;
}
